let project = require("./getProject.js");

const Alexa = require('ask-sdk-core');

const OauthIntentHandler = {
  canHandle(handlerInput) {
    return Alexa.getRequestType(handlerInput.requestEnvelope) === 'IntentRequest'
      && Alexa.getIntentName(handlerInput.requestEnvelope) === 'OauthIntent';
  },
  async handle(handlerInput) {
	  var speechText = 'Here are your tasks: ';
	  var accessToken = handlerInput.requestEnvelope.context.System.user.accessToken;
	  let body = await project.getProjects(accessToken);
	for (let i = 0; i < body.length; i++) {
		speechText += body[i].content + ", ";
	}

	  if (speechText == 'Here are your tasks: '){
		  speechText = 'You have no tasks in your Class list, or you have no Class list.';
	  }
    return handlerInput.responseBuilder
      .speak(speechText)
      .withSimpleCard('Oauth', speechText)
      .getResponse();
  }
};


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
    skill = Alexa.SkillBuilders.custom()
      .addRequestHandlers(
        LaunchRequestHandler,
        OauthIntentHandler,
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

