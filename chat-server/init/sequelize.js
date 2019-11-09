const Sequelize = require('sequelize');

const path = 'mysql://root:password@localhost:3306/translation_db';
const sequelize = new Sequelize(path, {
  logging: false,
  define: {
    timestamps: false
  }
});

sequelize.authenticate().then(() => {
  console.log('Database connection established successfully.');
}).catch(err => {
  console.error('Unable to connect to the database:', err);
});
module.exports = sequelize;