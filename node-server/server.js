const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const mongoose = require('mongoose');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);


const MONGO_DB_URI = "Setear aca la ruta de la base de datos";
// Ejemplo const MONGO_DB_URI = "mongodb://127.0.0.1:27017/laravel?directConnection=true&serverSelectionTimeoutMS=2000&appName=mongosh+2.0.2";

mongoose.connect(MONGO_DB_URI, {
  useNewUrlParser: true,
  useUnifiedTopology: true
});

const pedidoSchema = new mongoose.Schema({
  cuenta: Object,
  pedido: Object
});

const Pedido = mongoose.model('Pedido', pedidoSchema);

app.use(express.json());

app.post('/send-notification', (req, res) => {
  const data = req.body;
  console.log('Notificación recibida:', data);

  const nuevoPedido = new Pedido(data);
  nuevoPedido.save()
    .then(() => {
      io.emit('newPedido', data);
      res.status(200).send('Notificación enviada.');
    })
    .catch((err) => res.status(500).send('Error al almacenar pedido en MongoDB'));
});

server.listen(3000, () => {
  console.log('Servidor WebSocket ejecutándose en el puerto 3000');
});