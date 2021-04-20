/*
 * Scott Campbell
 * CSE451 Spring 2021
 * Simple Alexa Skill
 * Intents
 * GetNewFact
 * HelloWorld
 * GetWeather
 * */

const Alexa = require('ask-sdk-core');
let weather = require("./getWeather.js");

const LaunchRequestHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'LaunchRequest';
  },
  handle(handlerInput) {
    const speechText = 'Welcome to Scott Campbells Alexa Skill';

    return handlerInput.responseBuilder
      .speak(speechText)
      .reprompt(speechText)
      .withSimpleCard('Hello World', speechText)
      .getResponse();
  }
};

const GetWeatherIntentHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'IntentRequest'
      && Alexa.getIntentName(handlerInput.requestEnvelope) === 'GetWeatherIntent';
  },
  async handle(handlerInput) {
    let speechText = 'This is a new skill from Scott Campbell at Miami University';
	  let temp = await weather.getTemp();
	  speechText += " and the temperature is " + temp + " degrees";

    return handlerInput.responseBuilder
      .speak(speechText)
      .withSimpleCard('Temp', speechText)
      .getResponse();
  }
};

const GetHometownWeatherIntentHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'IntentRequest'
      && Alexa.getIntentName(handlerInput.requestEnvelope) === 'GetHometownWeatherIntent';
  },
  async handle(handlerInput) {
    let speechText = 'This is a new skill from Bryan Hayes at Miami University, the weather in Hamilton right now is ';
          let temp = await weather.getHomeTemp();
          speechText += temp + " degrees";

    return handlerInput.responseBuilder
      .speak(speechText)
      .withSimpleCard('Temp', speechText)
      .getResponse();
  }
};


const GetNewFactIntentHandler = {
  canHandle(handlerInput) {
	  console.log(Alexa.getIntentName(handlerInput.requestEnvelope));
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'IntentRequest'
      && Alexa.getIntentName(handlerInput.requestEnvelope) === 'GetNewFactIntent';
  },
  handle(handlerInput) {
    const facts = ["Two plus Two is not equal to five","It is unlikely that today is the 32nd day of the month", "The scientific term for brain freeze is sphenopalatine ganglioneuralgia","Canadians say sorry so much that a law was passed in 2009 declaring that an apology can’t be used as evidence of admission to guilt.","Back when dinosaurs existed, there used to be volcanoes that were erupting on the moon.","The only letter that doesn’t appear on the periodic table is J.","One habit of intelligent humans is being easily annoyed by people around them, but saying nothing in order to avoid a meaningless argument.","If a Polar Bear and a Grizzly Bear mate, their offspring is called a Pizzy Bear.","In 2006, a Coca-Cola employee offered to sell Coca-Cola secrets to Pepsi. Pepsi responded by notifying Coca-Cola"];
    let speechText = facts[Math.floor(Math.random() * facts.length)];

    return handlerInput.responseBuilder
      .speak(speechText)
      .withSimpleCard('Fact', speechText)
      .getResponse();
  }
};


const HelloWorldIntentHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'IntentRequest'
      && Alexa.getIntentName(handlerInput.requestEnvelope) === 'HelloWorldIntent';
  },
  handle(handlerInput) {
    const speechText = 'Hello World!';

    return handlerInput.responseBuilder
      .speak(speechText)
      .withSimpleCard('Hello World', speechText)
      .getResponse();
  }
};

const HelpIntentHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'IntentRequest'
      && Alexa.getIntentName(handlerInput.requestEnvelope) === 'AMAZON.HelpIntent';
  },
  handle(handlerInput) {
    const speechText = 'You can say hello to me!';

    return handlerInput.responseBuilder
      .speak(speechText)
      .reprompt(speechText)
      .withSimpleCard('Hello World', speechText)
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
  handle(handlerInput) {
    //any cleanup logic goes here
    return handlerInput.responseBuilder.getResponse();
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
    skill = Alexa.SkillBuilders.custom()
      .addRequestHandlers(
        LaunchRequestHandler,
        GetWeatherIntentHandler,
	GetHometownWeatherIntentHandler,
        GetNewFactIntentHandler,
        HelloWorldIntentHandler,
        HelpIntentHandler,
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

