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

                        let inputVal = document.getElementById(elements[i].id).value
                        var patt = /^[0-9]+$/;
                        if(patt.test(inputVal))
                        {
                            document.getElementById(elements[i].id).value = inputVal;
                        }
                        else
                        {
                            var txt = inputVal.slice(0, -1);
                            document.getElementById(elements[i].id).value = txt;
                        }
                })
            }
        }   
    }
})















