const Sequelize = require('sequelize');
const sequelize = require('../init/database');
class SocialProfile extends Sequelize.Model { }

SocialProfile.init({
    id: { type: Sequelize.INTEGER, primaryKey: true, autoIncrement: true },
    userId: Sequelize.INTEGER,
    instagram: Sequelize.STRING,
    twitter: Sequelize.STRING,
    github: Sequelize.STRING,
    linkedin: Sequelize.STRING,
    telegram: Sequelize.STRING,
    facebook: Sequelize.STRING,
    isEmailPublic: Sequelize.TINYINT
}, { sequelize, modelName: 'social_profile' });



module.exports = SocialProfile;