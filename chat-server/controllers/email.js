const request = require('request');

const saveEmail = function (req, res) {
    request({
        url: 'https://us4.api.mailchimp.com/3.0/lists/e41c5c03b4/members',
        method: 'POST',
        headers: {
            'Authorization': 'randomUser dc141ab17c8a5edea386a1e8824f3fd1-us4',
            'Content-Type': 'application/json'
        },
        json: {
            'email_address': req.body.email,
            'status': 'subscribed'
        }
    }, (err, response, body) => {
        if (err) {
            console.log("Error", err);
            return res.json({ ok: 0 });
        }
        console.log("Response", response, " Body", body);
        res.json({ ok: 1 });
    });

};
const sendEmail = function (req, res) {
    request({
        url: 'https://us4.api.mailchimp.com/3.0/templates/210241',
        method: 'PATCH',
        headers: {
            'Authorization': 'randomUser dc141ab17c8a5edea386a1e8824f3fd1-us4',
            'Content-Type': 'application/json'
        },
        json: {
            name: 'LLC Template',
            html: `<p>${req.body.body}</p>`
        }
    }, (err, response, body) => {
        if (err) {
            console.log("Error", err);
            return res.json({ ok: 0 });
        }
        createCampaign(req, res, (campaignId) => {
            request({
                url: 'https://us4.api.mailchimp.com/3.0/campaigns/' + campaignId + '/actions/send',
                method: 'POST',
                headers: {
                    'Authorization': 'randomUser dc141ab17c8a5edea386a1e8824f3fd1-us4',
                    'Content-Type': 'application/json'
                }
            }, (err, response, body) => {
                if (err) {
                    console.log("Error", err);
                    return res.json({ ok: 0 });
                }
                console.log(body);
                res.json({ ok: 1 });
            });
        })
    });

};
function createCampaign(req, res, callback) {
    request({
        url: 'https://us4.api.mailchimp.com/3.0/campaigns',
        method: 'POST',
        headers: {
            'Authorization': 'randomUser dc141ab17c8a5edea386a1e8824f3fd1-us4',
            'Content-Type': 'application/json'
        },
        json: {
            type: 'regular',
            settings: {
                'subject_line': req.body.title,
                'preview_text': req.body.body,
                'from_name': 'Irvi Lloshi',
                'reply_to': 'irvilloshi@gmail.com',
                'template_id': 210241
            },
            recipients: {
                list_id: 'e41c5c03b4'
            }
        }
    }, (err, response, body) => {
        if (err) {
            console.log("Error", err);
            return res.json({ ok: 0 });
        }
        callback(body.id);
    });
}
const getEmails = function (req, res) {
    request({
        url: 'https://us4.api.mailchimp.com/3.0/lists/e41c5c03b4/members',
        method: 'GET',
        headers: {
            'Authorization': 'randomUser dc141ab17c8a5edea386a1e8824f3fd1-us4'
        }
    }, (err, response, body) => {
        if (err) {
            console.log("Error", err);
            return res.json({ ok: 0 });
        }
        res.json(JSON.parse(body).members);
    });
};


module.exports.saveEmail = saveEmail;
module.exports.sendEmail = sendEmail;
module.exports.getEmails = getEmails;