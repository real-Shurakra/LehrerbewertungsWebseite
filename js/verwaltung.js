// verwaltung.js

import Gui from "./Gui.js";
import Questionnaire from "./Questionnaire.js";
import Question from "./Question.js";
import Page from "./Page.js";
import FunctionMannager from "./FunctionMannager.js";
import ToolTipCreator from "./ToolTipCreator.js";

var gui = new Gui();
var functionMannager = new FunctionMannager();

var toolTipCreator = new ToolTipCreator();


gui.functionMannager = functionMannager;
gui.functionMannager.toolTipCreator = toolTipCreator;

gui.loadSvgAndMenus("verwaltung");


/*
let toolTip = toolTipCreator.createToolTip();
document.body.appendChild(toolTip);

document.addEventListener("mousemove", (event)=>{
    let toolTipHeightHalf =  parseInt(toolTip.style.height) / 2;
    let toolTipWidth = parseInt(toolTip.style.width);
    toolTip.style.top = event.clientY - toolTipHeightHalf + "px";
    toolTip.style.left = window.innerWidth - (toolTipWidth + 40) + "px";
});
*/









