var config = require("./config.json");
var aws = require('aws-sdk');
var lambda = new aws.Lambda({region: config.lambda.region});

function MassEmailSender(recipients, templateName, templateData) {
    this.recipients = recipients;       // An array of recipient objects
    this.templateName = templateName;   // The name of an outbound email template
    this.templateData = templateData;   // A map of k/v pairs to pass in to the template
}

MassEmailSender.prototype.validateRecipient = function validateRecipient(recipient) {
    if (!recipient.emailAddress) {
        throw new Error("Recipient emailAddress cannot be empty");
    }
    if (!recipient.name) {
        throw new Error("Recipient name cannot be empty");
    }
    return true;
};

MassEmailSender.prototype.getDomain = function getDomain(emailAddress) {
    return emailAddress.replace(/.*@/, "")
};


MassEmailSender.prototype.getPayloadForRecipient = function getPayloadForRecipient(recipient, templateName, templateData) {
    return {
        FunctionName: config.lambda.functionName,
        InvocationType: config.lambda.invocationType,
        Payload: new Buffer(JSON.stringify({
            recipient: recipient,
            templateName: templateName,
            templateData: templateData
        }))
    };
};


MassEmailSender.prototype.send = function send()
{
    for (var i=0; i<this.recipients.length; i++) {
        var recipient = this.recipients[i];
        try {
            this.validateRecipient(recipient)
        } catch (error) {
            console.log("[mass_email_sender] skipping an invalid recipient", JSON.stringify(recipient), error.message);
            return;
        }

        var payload = this.getPayloadForRecipient(recipient, this.template, this.templateData);
        lambda.invoke(payload, function (error, result) {
            if (error) {
                console.log("[mass_email_sender] failed to send a message with error", error.message);
                return;
            }

            console.log("[mass_email_sender] successfully sent a message", result);
        });
    }
};

module.exports = MassEmailSender;