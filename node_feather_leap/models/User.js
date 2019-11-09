const Sequelize = require('sequelize');
const sequelize = require('../init/database');
const SocialProfile = require('./SocialProfile');
const PublicProfile = require('./PublicProfile');

class User extends Sequelize.Model { }

User.init({
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    email: {
        type: Sequelize.STRING,
        validate: {
            notEmpty: {
                msg: "Email Required"
            }
        },
    },
    fullName: {
        type: Sequelize.STRING,
        validate: {
            notEmpty: {
                msg: 'Full Name Required'
            }
        }
    },
    username: {
        type: Sequelize.STRING,

        validate: {
            notEmpty: {
                msg: "Username Required"
            },
        }, unique: {
            args: true,
            msg: "Username already exists"
        }
    },
    password: {
        type: Sequelize.STRING,
        validate: {
            notEmpty: {
                msg: "Password Required"
            },
            len: {
                args: [8],
                msg: 'Password must contain atleast 8 characters'
            }
        }
    },
    avatar: Sequelize.STRING,
    isFirstLogin: Sequelize.TINYINT,
    verified: Sequelize.TINYINT,
    verificationToken: Sequelize.STRING
}, { sequelize, modelName: 'users' });

User.hasOne(PublicProfile, { foreignKey: 'userId' });
User.hasOne(SocialProfile, { foreignKey: 'userId' });

module.exports = User;