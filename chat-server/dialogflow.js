const dialogflow = require('dialogflow');
const uuid = require('uuid');
(async function (projectId = 'dialogflow-250814') {
    const sessionId = uuid.v4();
    const sessionClient = new dialogflow.SessionsClient();
    const sessionPath = sessionClient.sessionPath(projectId, sessionId);
    const request = {
        session: sessionPath,
        queryInput: {
            text: {
                text: 'Hello',
                languageCode: 'en-US'
            }
        }
    };
    // console.log(sessionPath);
    const responses = await sessionClient.detectIntent(request);
    // console.log('Detected Intent');
    const result = responses[0].queryResult;
    console.log(`   Query: ${result.queryText}`);
    console.log(`   Query: ${result.fulfillmentText}`);
    if (result.intent) {
        console.log(`   Intent: ${result.intent.displayName}`);
    } else {
        console.log('No intent matched');
    }
});
module.exports = {
    init: async function () {
        this.projectId = 'dialogflow-250814';
        this.sessionId = uuid.v4();
        this.sessionClient = new dialogflow.SessionsClient();
        this.intentClient = new dialogflow.v2.IntentsClient();
        /*  QuestionAnswer  'bb702a55-e808-443e-a826-aa564dad586a'*/
        /*  Default Welcome Intent 'a5df073c-0d75-4e1c-b68d-f6b086ce2473' */
        this.intentPath = this.intentClient.intentPath(this.projectId, 'a5df073c-0d75-4e1c-b68d-f6b086ce2473');
        this.sessionPath = this.sessionClient.sessionPath(this.projectId, this.sessionId);
        const request = {
            session: this.sessionPath,
            queryInput: {  
                text: {
                    text: 'Hello',
                    languageCode: 'en-US'
                }
            }
        };
        return await this.makeRequest(request);
    },
    makeRequest: async function (requestObj) {
        return await this.sessionClient.detectIntent(requestObj);
    }
};