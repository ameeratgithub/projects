
const Sequelize = require('sequelize');

const sequelize = new Sequelize('node_feather_leap', 'root', 'password', {
  host: 'localhost',
  dialect: 'mysql',
  logging: false,
  define: {
    timestamps: false
  }
});
sequelize.authenticate()
  .then(() => {
    console.log("Database connected!");
  })
  .catch(err => {
    console.error('Unable to connect', err);
  });
module.exports = sequelize;