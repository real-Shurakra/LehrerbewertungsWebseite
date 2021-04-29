// index.js

import Gui from "./Gui.js";
import Questionnaire from "./Questionnaire.js";
import Question from "./Question.js";
import Page from "./Page.js";
import FunctionMannager from "./FunctionMannager.js";

var gui = new Gui();
var functionMannager = new FunctionMannager();

gui.functionMannager = functionMannager;

gui.loadSvgAndMenus("index");










