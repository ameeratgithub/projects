const Sequelize = require('sequelize');
const sequelize = require('../init/database');
class PublicProfile extends Sequelize.Model { }

PublicProfile.init({
    id: { type: Sequelize.INTEGER, primaryKey: true, autoIncrement: true },
    userId: Sequelize.INTEGER,
    tagline: Sequelize.STRING,
    areaOfExpertise: {
        type: Sequelize.STRING,
        validate: {
            notEmpty: {
                msg: 'Area of Expertise Required'
            }
        }
    },
    color:  {
        type: Sequelize.STRING,
        validate: {
            notEmpty: {
                msg: 'Color Required'
            }
        }
    },
    greetViewers: Sequelize.STRING,
    things: Sequelize.STRING,
    buttonText: Sequelize.STRING,
    buttonUrl: Sequelize.STRING,
    bio: Sequelize.STRING,
    
}, { sequelize, modelName: 'public_profile' });


module.exports = PublicProfile;