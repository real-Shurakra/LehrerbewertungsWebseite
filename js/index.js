// index.js

import Gui from "./Gui.js";
import Questionnaire from "./Questionnaire.js";
import Question from "./Question.js";
import Page from "./Page.js";
import FunctionManager from "./FunctionManager.js";

var gui = new Gui();
var objectFunctionManager = new FunctionManager();

gui.functionManager = objectFunctionManager;

gui.loadSvgAndMenus("index");


/*
// Begrenzung der Codeeingabe des Schülerbereiches auf Zahlen und zwei Ziffern
document.addEventListener("mousedown", ()=>{
    if (document.getElementById("input_area_students") != undefined);
    {
        var elements = document.getElementsByClassName("input_student");
        if (elements.length != 0)
        {
            for(let i = 0; i < elements.length; i++)
            {
                elements[i].addEventListener("input", ()=>{

                        let inputField = document.getElementById(elements[i].id);

                        let inputVal = inputField.value
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

                        // Automatisches Auswählen des nächsten Eingabefeldes, sobald das aktuelle ausgefüllt ist
                        if(inputVal.length == 2)
                        {
                            let nextNumber = parseInt(inputField.id.substr(2, 1)) + 1;
                            let nextElement = document.getElementById("nr" + nextNumber);
                            if (nextElement != undefined)
                            {
                                nextElement.focus();
                                nextElement.value = "";
                            }
                        }
                })
            }
        }   
    }
})
*/

















