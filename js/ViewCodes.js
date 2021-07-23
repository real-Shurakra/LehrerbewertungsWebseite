// Klasse ViewCodes
// Dient der Darstellung der Codes in einer Tabelle für den Ausdruck
// (wird in eigenem Tab geöffnet

export default class ViewCodes
{
    constructor()
    {
        this.codes = [];
        this.qSubject;
        this.subject;
    }

    getCodes(fbId, qSubject, subject, className)
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
                tempTable.style.width = "25%";
                tempTable.style.borderCollapse = "collapse";
                tempTable.style.borderWidth = "2px";
                tempTable.style.fontFamily = "consolas monospace";
                tempTable.style.fontSize = "20px";

                // Fragebogen Codes in Tabelle darstellen
			    for(let i = 0; i < responseQuestionnaireCodes.returnvalue.length; i++)
				{
					//this.codes.push(responseQuestionnaireCodes.returnvalue[i].codehash);
                    let tempTr = document.createElement("tr");
                    tempTr.style.borderStyle = "dashed";
                    tempTr.style.borderWidth = "2px";
                    tempTr.style.width = "99%";
                    tempTr.style.padding = "50px";
                    tempTr.style.height = "30px";

                    let tempTdQSubject = document.createElement("td");
                    tempTdQSubject.innerHTML = qSubject;
                    //tempTdQSubject.style.borderStyle = "dashed";
                    tempTr.appendChild(tempTdQSubject);

                    let tempTdClass = document.createElement("td")
                    tempTdClass.innerHTML = className;
                    //tempTdClass.style.borderStyle = "dashed";
                    tempTr.appendChild(tempTdClass);

                    let tempTdCode = document.createElement("td");
                    tempTdCode.innerHTML = responseQuestionnaireCodes.returnvalue[i].codehash;
                    //tempTdCode.style.borderStyle = "dashed";
                    tempTr.appendChild(tempTdCode);

                    tempTable.appendChild(tempTr);
				}
                tempTable.style.borderStyle = "dashed";
                tempTable.style.fontSize = "16px";

                //console.log(this.codes);
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

console.log(fbId);
console.log(qSubject);
console.log(subject);
console.log(className);

viewCodes.getCodes(fbId, qSubject, subject, className);
