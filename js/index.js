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

document.addEventListener("mousedown", ()=>{
    if (document.getElementById("input_area_students") != undefined);
    {
        var elements = document.getElementsByClassName("input_student");
        console.log(elements);
        if (elements.length != 0)
        {
            for(let i = 0; i < elements.length; i++)
            {
                elements[i].addEventListener("input", ()=>{
                    var charArray = elements[i].value.split(',');
                    if(charArray.length > 0)
                    {
                        for(let j = 0; j < charArray.length; j++)
                        {
                            if(charArray[j] < '0' || charArray[j] > '9' )
                            {
                                charArray[j] = "";
                                elements[i].value = charArray;
                                console.log("Es dürfen nur Zahlen eingegeen werden!");
                            }
                        }
                    }
                })
            }
        }
    }   
})















