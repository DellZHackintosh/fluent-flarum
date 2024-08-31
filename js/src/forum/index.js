import app from 'flarum/forum/app';
import { extend, override } from 'flarum/common/extend';
import standaloneLoginModal from './components/standaloneLoginModal';
import DiscussionList from 'flarum/forum/components/DiscussionList';
import HeaderSecondary from 'flarum/forum/components/HeaderSecondary';
import Button from 'flarum/common/components/Button';

/**
 * Hits the API endpoint by calling `app.store.find('')`, which will load
 * all initial data that the user should have set.
 */
async function loadBaseApiData() {
    await app.store.find('');
}

/**
 * Hides the provided modal, and calls the `loaded` method on that modal.
 */
function closeModal(modalInstance) {
    modalInstance.hide();
    modalInstance.loaded?.call(modalInstance);
}

function trans(key) {
    return app.translator.trans(`dalez-identityagent.forum.${key}`);
}

const userAgent = (() => {
    let token, originalUser;
    const requestOld = app.request;

    function startActing(tokenString, userID) {
        token = tokenString;
        originalUser = userID;
        app.request = (options) => {
            let optionsWithToken = { ...options };
            optionsWithToken.headers = optionsWithToken.headers || {};
            optionsWithToken.headers.Authorization = `Token ${token}`;
            return requestOld.call(window.app, optionsWithToken);
        };
    }

    async function stopActing() {
        await loadBaseApiData();
        app.session.user = originalUser;
        app.request = requestOld.bind(window.app);
        app.acting = false;
        m.redraw();
    }

    return {
        startActing,
        stopActing,
    };
})();

app.initializers.add('dalez-identityagent', () => {
    const userData = data.resources.find((element) => {
        return element.type === 'users' && data.session.userId == element.id;
    }).attributes;

    extend(DiscussionList.prototype, 'view', function () {
        if (app.newLogin) {
            delete app.newLogin;
        }
    });

    extend(standaloneLoginModal.prototype, 'fields', async function (items) {
        items.remove('remember');
    });

    override(standaloneLoginModal.prototype, 'onsubmit', async function (original, e) {
        e.preventDefault();

        this.loading = true;

        const loginData = this.loginParams();

        const response = await app.request({
            method: 'POST',
            url: `${app.forum.attribute('baseUrl')}/api/token`,
            body: loginData,
            errorHandler: this.onerror.bind(this),
        });

        if (!response) return;

        const { token, userId } = response;

        userAgent.startActing(token, app.session.user);

        await loadBaseApiData();

        app.session.user = app.store.getById('users', userId);
        app.acting = true;

        closeModal(this);
    });

    if (userData.canUseFeature)
        extend(HeaderSecondary.prototype, 'items', function (items) {
            items.add(
                'nightmode',
                <Button
                    className="Button Button--flat"
                    onclick={() => {
                        if (app.acting === true) {
                            if (window.confirm(trans('confirmation'))) userAgent.stopActing();
                        } else app.modal.show(standaloneLoginModal);
                    }}
                    icon={app.acting === true ? 'fas fa-user-cog' : 'fas fa-user'}
                >
                    {trans('button_text')}
                </Button>,
                15
            );
        });
});
