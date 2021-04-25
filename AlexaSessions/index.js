/*
 * Scott Campbell
 * CSE451 Spring 2021
 * Simple Alexa Skill
 * Intents
 * GetNewFact
 * HelloWorld
 * GetWeather
 * */


const { DynamoDbPersistenceAdapter } = require('ask-sdk-dynamodb-persistence-adapter');
const dynamoDbPersistenceAdapter = new DynamoDbPersistenceAdapter({ tableName : 'AlexaSessions'})
let attributes = {"color":"", "city":"", "comic":""};

const Alexa = require('ask-sdk-core');

const LaunchRequestHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'LaunchRequest';
  },
  async handle(handlerInput) {
    const speechText = 'Welcome to Scott Campbells Alexa Skill';
	  const attributesManager = handlerInput.attributesManager;
	attributes = await attributesManager.getPersistentAttributes() || {"color":"", "city":"", "comic":""};

    return handlerInput.responseBuilder
      .speak(speechText)
      .reprompt(speechText)
      .withSimpleCard('Hello World', speechText)
      .getResponse();
  }
};

const FavoriteCityIntentHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'IntentRequest'
      && Alexa.getIntentName(handlerInput.requestEnvelope) === 'FavoriteCityIntent';
  },
  async handle(handlerInput) {
    var city = Alexa.getSlotValue(handlerInput.requestEnvelope, "city");
    let speechText = 'Your favorite city is ' + city;
    attributes["city"] = city;
const attributesManager = handlerInput.attributesManager;
    attributesManager.setPersistentAttributes(attributes);
    await attributesManager.savePersistentAttributes();


    return handlerInput.responseBuilder
      .speak(speechText)
      .withSimpleCard('City', speechText)
      .getResponse();
  }
};

const FavoriteComicIntentHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'IntentRequest'
      && Alexa.getIntentName(handlerInput.requestEnvelope) === 'FavoriteComicIntent';
  },
  async handle(handlerInput) {
    var comic = Alexa.getSlotValue(handlerInput.requestEnvelope, "comic");
    let speechText = 'Your favorite comic is ' + comic;
    attributes["comic"] = comic;
const attributesManager = handlerInput.attributesManager;
    attributesManager.setPersistentAttributes(attributes);
    await attributesManager.savePersistentAttributes();

    return handlerInput.responseBuilder
      .speak(speechText)
      .withSimpleCard('Comic', speechText)
      .getResponse();
  }
};

const GetFavoritesIntentHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'IntentRequest'
      && Alexa.getIntentName(handlerInput.requestEnvelope) === 'GetFavoritesIntent';
  },
  async handle(handlerInput) {
    const color = attributes.hasOwnProperty('color') ? attributes.color : "";
    const city = attributes.hasOwnProperty('city') ? attributes.city : "";
    const comic = attributes.hasOwnProperty('comic') ? attributes.comic : "";
    let speechText = "";
    if (color == ""){
	speechText = "You don't have a favorite color.  You should tell me it!";
    } else if (city == ""){
        speechText = "You don't have a favorite city.  You should tell me it!";
    } else if (comic == ""){
        speechText = "You don't have a favorite comic.  You should tell me it!";
    } else {
	speechText = "Your favorite color is " + color + ", your favorite city is " + city + ", and your favorite comic is " + comic + ".";
    }

    return handlerInput.responseBuilder
      .speak(speechText)
      .withSimpleCard('Favorites', speechText)
      .getResponse();
  }
};

const FavoriteColorIntentHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'IntentRequest'
      && Alexa.getIntentName(handlerInput.requestEnvelope) === 'FavoriteColorIntent';
  },
  async handle(handlerInput) {
    var color = Alexa.getSlotValue(handlerInput.requestEnvelope, "color");
    let speechText = 'Your favorite color is ' + color;
    attributes["color"] = color;
	const attributesManager = handlerInput.attributesManager;
    attributesManager.setPersistentAttributes(attributes);
    await attributesManager.savePersistentAttributes();

    return handlerInput.responseBuilder
      .speak(speechText)
      .withSimpleCard('Color', speechText)
      .getResponse();
  }
};



const CancelAndStopIntentHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'IntentRequest'
      && (Alexa.getIntentName(handlerInput.requestEnvelope) === 'AMAZON.CancelIntent'
        || Alexa.getIntentName(handlerInput.requestEnvelope) === 'AMAZON.StopIntent');
  },
  handle(handlerInput) {
    const speechText = 'Goodbye!';

    return handlerInput.responseBuilder
      .speak(speechText)
      .withSimpleCard('Hello World', speechText)
      .withShouldEndSession(true)
      .getResponse();
  }
};


const SessionEndedRequestHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'SessionEndedRequest';
  },
  async handle(handlerInput) {
    //any cleanup logic goes here
    const attributesManager = handlerInput.attributesManager;
    attributesManager.setPersistentAttributes(attributes);
    await attributesManager.savePersistentAttributes();

    return handlerInput.responseBuilder.withShouldEndSession(true).getResponse();
  }
};

const ErrorHandler = {
  canHandle() {
    return true;
  },
  handle(handlerInput, error) {
    console.log(`Error handled: ${error.message}`);

    return handlerInput.responseBuilder
      .speak('Sorry, I can\'t understand the command. Please say again.')
      .reprompt('Sorry, I can\'t understand the command. Please say again.')
      .getResponse();
  },
};

let skill;

exports.handler = async function (event, context) {
  console.log(`REQUEST++++${JSON.stringify(event)}`);
  if (!skill) {
    skill = Alexa.SkillBuilders.custom().withPersistenceAdapter(dynamoDbPersistenceAdapter)
      .addRequestHandlers(
        LaunchRequestHandler,
        FavoriteColorIntentHandler,
	FavoriteCityIntentHandler,
	FavoriteComicIntentHandler,
	GetFavoritesIntentHandler,
        CancelAndStopIntentHandler,
        SessionEndedRequestHandler,
      )
      .addErrorHandlers(ErrorHandler)
      .create();
  }

  const response = await skill.invoke(event, context);
  console.log(`RESPONSE++++${JSON.stringify(response)}`);

  return response;
};

