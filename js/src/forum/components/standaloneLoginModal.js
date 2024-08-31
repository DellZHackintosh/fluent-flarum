import LogInModal from 'flarum/forum/components/LogInModal';

// Only for preventing pollution
export default class extends LogInModal {
    constructor() {
        super();
    }

    title() {
        return app.translator.trans('dalez-identityagent.forum.login.title');
    }

    footer() {
        return (
            <>
                <p>{app.translator.trans('dalez-identityagent.forum.login.note')}</p>
            </>
        );
    }
}
