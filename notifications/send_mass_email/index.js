var MassEmailSender = require('./mass_email_sender');

var sendMassEmail = function sendMassEmail(recipients, templateName, templateData) {
    if (typeof recipients === 'undefined' || recipients.length === 0) {
        throw new Error("Invalid recipient list: ", recipients);
    }
    if (!templateName) throw new Error("No email template specified");
    if (typeof templateData !== 'object') throw new Error("No template data provided");

    return (new MassEmailSender(recipients, templateName, templateData)).send();
};

exports.handler = function (event, context) {
    console.log("[send_mass_email] incoming event: ", event);
    try {
        sendMassEmail(event.recipients, event.templateName, event.templateData);
        console.log("[send_mass_email] processing completed successfully");
        context.succeed(event);
    } catch (error) {
        console.log("[send_mass_email] processing encountered an error :", error.message);
        context.fail(error.message);
    }
};
