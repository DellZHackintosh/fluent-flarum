import app from "flarum/admin/app";
import Alert from "flarum/common/components/Alert";

function withID(more = "") {
  return `dalez-fluent-flarum${more}`;
}

function trans(name) {
  return app.translator.trans(name);
}

app.initializers.add(withID(), () => {
  app.extensionData
    .for(withID())
    .registerSetting(function () {
      const disable = app.data.settings["dalez-fluent-flarum.disableBeta"];
      if (disable === "1" || disable) return;

      return (
        <div className="Form-group">
          <Alert dismissible={false}>{trans(withID(".admin.beta"))}</Alert>
        </div>
      );
    })
    .registerSetting({
      setting: withID(".disableBeta"),
      label: trans(withID(".admin.disable_beta_label")),
      help: trans(withID(".admin.disable_beta_help")),
      type: "boolean",
    })
    .registerSetting({
      setting: withID(".background"),
      label: trans(withID(".admin.background_label")),
      type: "select",
      options: {
        solid: trans(withID(".admin.solid")),
        bing_red: trans(withID(".admin.bing_red")),
        bing_green: trans(withID(".admin.bing_green")),
        bing_blue: trans(withID(".admin.bing_blue")),
        mica_accent: trans(withID(".admin.mica_accent")),
        mica_colorful: trans(withID(".admin.mica_colorful"))
      },
      default: "solid",
    });
});
