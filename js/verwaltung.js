// verwaltung.js

import Gui from "./Gui.js";
import Questionnaire from "./Questionnaire.js";
import Question from "./Question.js";
import Page from "./Page.js";
import FunctionManager from "./FunctionManager.js";
import ToolTipCreator from "./ToolTipCreator.js";

var gui = new Gui();
var objectFunctionManager = new FunctionManager();
objectFunctionManager.menuBarColor = gui.menuBarColor;
objectFunctionManager.menuOpacity = gui.menuOpacity;

var toolTipCreator1 = new ToolTipCreator();
var toolTipCreator2 = new ToolTipCreator();


gui.functionManager = objectFunctionManager;
gui.functionManager.toolTipCreator1 = toolTipCreator1;
gui.functionManager.toolTipCreator2 = toolTipCreator2;

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









