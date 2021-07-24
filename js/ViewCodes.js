// Klasse ViewCodes
// Dient der Darstellung der Codes in einer Tabelle für den Ausdruck
// (wird in eigenem Tab geöffnet

export default class ViewCodes
{
    constructor()
    {
        this.menuBarColor = "#191f51"; // Marineblau
        this.unhighlightedColor = "#9eb3c7"; // helles Grau-Blau
    }

    CreateCodesTable(fbId, qSubject, subject, className)
    {
        // Asynchroner Request
		let xhttp = new XMLHttpRequest()
		let path = "../php/main.php?mode=getCodes";

		let formDataCodes = new FormData();
		formDataCodes.append("fbId", fbId);

		xhttp.onreadystatechange = ()=>{
			if ( xhttp.readyState == 4 && xhttp.status == 200 )
			{
				var responseQuestionnaireCodes = JSON.parse(xhttp.responseText);
                console.log(responseQuestionnaireCodes);

                let tempTable = document.getElementById("codes_table");
                tempTable.style.width = "826px";
                tempTable.style.height = "1169px";
                tempTable.style.borderCollapse = "collapse";
                tempTable.style.fontFamily = "calibri";
                tempTable.style.fontWeight = "bold";
                tempTable.style.fontSize = "25px";

                // Fragebogen Codes in Tabelle darstellen
			    for(let i = 0; i < responseQuestionnaireCodes.returnvalue.length; i++)
				{
                    let tempTr = document.createElement("tr");
                    tempTr.className = "tempTdQuestionnaire";

                    tempTr.style.width = "99%";
                    tempTr.style.padding = "auto";
                    tempTr.style.textAlign = "center";

                    if(i > 0 && i < responseQuestionnaireCodes.returnvalue.length)
                    {
                        tempTr.style.borderWidth = "2px";
                        tempTr.style.borderTop = "dashed";
                        tempTr.style.borderRight = "none";
                        tempTr.style.borderLeft = "none";
                        tempTr.style.borderBottom = "none";
                    }

                    let tempTdQSubject = document.createElement("td");
                    tempTdQSubject.innerHTML = qSubject;
                    tempTr.appendChild(tempTdQSubject);

                    let tempTdClass = document.createElement("td")
                    tempTdClass.innerHTML = className;
                    tempTr.appendChild(tempTdClass);

                    let tempTdSubject = document.createElement("td")
                    tempTdSubject.innerHTML = subject;
                    tempTr.appendChild(tempTdSubject);

                    let tempTdCode = document.createElement("td");
                    tempTdCode.innerHTML = responseQuestionnaireCodes.returnvalue[i].codehash;
                    tempTr.appendChild(tempTdCode);

                    tempTable.appendChild(tempTr);
				}
                tempTable.style.fontSize = "16px";
            }
        }
        xhttp.open("POST", path, true);
        xhttp.send(formDataCodes);
    }
}

function getParameter(name){
    console.log("getting Parameter: " + name);
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
       return decodeURIComponent(name[1]);
}

let viewCodes = new ViewCodes();
let fbId = getParameter("fbId");
let qSubject = getParameter("qSubject");
let subject = getParameter("subject");
let className = getParameter("className");

document.body.style.backgroundColor = "#F5F5F5";

viewCodes.CreateCodesTable(fbId, qSubject, subject, className);
