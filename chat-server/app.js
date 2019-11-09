const express = require('express');
const app = express();

const http = require('http').Server(app);
const io = require('socket.io')(http);
const cors = require('cors');
const bodyParser = require('body-parser');
const emailController = require('./controllers/email');

const exphbs = require('express-handlebars');

app.use(express.static('public'))
app.engine('.hbs', exphbs({ defaultLayout: false, extname: '.hbs' }));
app.set('view engine', '.hbs');

app.get('/', function (req, res) {
    res.render('index');
});
const corsOptions = {
    origin: 'http://localhost:4200',
    optionsSuccessStatus: 200
};
app.use(cors(corsOptions));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));
const chatbot = require('./dialogflow');

let totalClients = 0;
let activeClients = [];
let totalAdmins = 0;
let activeAdmins = [];

app.post('/saveEmail', emailController.saveEmail);
app.post('/sendEmail', emailController.sendEmail);
app.get('/getEmails', emailController.getEmails);

io.of('/admins').on("connection", socket => {
    const adminName = "anon_" + ++totalAdmins;
    socket.on("disconnect", socket => {
        activeAdmins = activeAdmins.filter(admin => admin.name !== adminName);
        console.log(activeAdmins);
        console.log(`Admin ${adminName} disconnected`);
    });
    socket.on('admin message', message => {
        const toClientRef = '/visitors#' + message.id;
        const clientSocket = io.of('/visitors').connected[toClientRef];
        console.log(message.id);
        clientSocket.emit("serverResponse", {
            text: message.text,
            type: 'message', sender: 'other', connectedTo: 'admin', sendTo: 'client'
        });
    });
    activeAdmins.push({ name: adminName, id: socket.client.id, clients: [] });
    console.log(`Admin ${adminName} connected`);
});
io.of('/visitors').on("connection", socket => {
    const clientName = "anon_" + ++totalClients;
    const socketId = socket.client.id;
    /*              For chat bot                */

    (async () => {
        const responses = await (await chatbot.init());
        const result = responses[0].queryResult.fulfillmentMessages;
        const messages = [];
        result.forEach(result => {
            const message = result.text.text[0];
            messages.push(
                { text: message, type: 'message', sender: 'other', connectedTo: 'chatbot' }
            );
        });
        socket.connectedTo = 'chatbot';
        socket.emit("room", clientName);
        socket.emit("serverResponse", messages);
    })();
    let toAdminRef, adminSocket, currentAdmin;
    socket.on("message", async message => {
        if (socket.connectedTo === 'chatbot') {
            const request = {
                session: chatbot.sessionPath,
                queryInput: {
                    text: {
                        text: message.text,
                        languageCode: 'en-US'
                    }
                }
            };
            const responses = await chatbot.makeRequest(request);
            const result = responses[0].queryResult;
            socket.emit("serverResponse",
                { text: result.fulfillmentText, type: 'message', sender: 'other', connectedTo: 'chatbot', sendTo: 'client' }
            );
        }
        else {
            io.of('/admins').to(toAdminRef).emit('client message',
                { text: message.text, type: 'message', sender: 'other', id: socket.client.id, name: clientName }
            );
        }
    });
    socket.on("connect-admin", room => {
        if (activeAdmins.length < 1) {
            socket.emit("serverResponse",
                {
                    text: 'Sorry, Currently no admin is available',
                    type: 'message', sender: 'other', connectedTo: 'chatbot', sendTo: 'client'
                }
            )
        } else {
            if (socket.connectedTo === 'admin') {
                socket.emit("serverResponse",
                    { text: 'Admin is already connected', type: 'notification' }
                );
                return;
            }
            currentAdmin = activeAdmins[0];
            socket.connectedTo = 'admin';
            toAdminRef = '/admins#' + currentAdmin.id;

            adminSocket = io.of('/admins').connected[toAdminRef];

            adminSocket.on('disconnect', () => {
                socket.connectedTo = 'chatbot';
                socket.emit("serverResponse",
                    { text: 'Admin is disconnected', type: 'notification' }
                );
            });

            currentAdmin.clients.push({ name: clientName, id: socket.client.id, newMessages: 0, messages: [] });
            adminSocket.emit('users list', currentAdmin.clients);
            socket.emit("serverResponse", { text: 'Admin is connected', type: 'notification' });
        }
    });
    socket.on("disconnect", () => {
        if (currentAdmin) {
            currentAdmin.clients = currentAdmin.clients.filter(c => c.id !== socket.client.id);
            adminSocket && adminSocket.emit('users list', currentAdmin.clients);
        }
        console.log(`Client ${clientName} disconnected`);
    });
    console.log(`Client ${clientName} connected`);
    activeClients.push({ name: clientName, id: socket.client.id });
});




http.listen(4444, () => {
    console.log("Chat server is running on port 4444");
});

app.listen(3000, () => {
    console.log('Web server is running on port 3000');
})