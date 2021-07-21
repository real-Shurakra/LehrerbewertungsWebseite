// Klasse Questionnaire

export default class Questionnaire
{
	constructor(questionnaire, questionnaireList)
	{
		// console.log("Aufruf von Klasse Questionnaire:");
		// console.log(questionnaire);

		this.menuBarColor;
		this.id;
		this.className;
		this.subject;
		this.amountStudents;
		this.questions;
		this.currentStatus;
		this.date;

		let div = document.getElementById(questionnaire.id);
		if (div !== null) div.remove();
		else
		{
			div = document.createElement("div");
			div.style.borderStyle = "solid";
			div.style.borderColor = "#9eb3c7";
			div.style.borderWidth = "1px";
			div.style.width = "99%";
			//div.style.visibility = "hidden";
			div.id = questionnaire.id;
			
	
			let tds = div.getElementsByClassName("questionnaireHeader");
			div.addEventListener("mouseenter", ()=>{
				div.style.cursor = "pointer";
				for(let td in tds)
				{
					if (tds[td].style != undefined)
					{
						tds[td].style.color = "#ffffff";
						tds[td].style.backgroundColor = this.menuBarColor;
						
					}
				}
			});
			div.addEventListener("mouseleave", ()=>{
				for(let td in tds)
				{
					if (tds[td].style != undefined)
					{
						tds[td].style.color = this.menuBarColor;
						tds[td].style.backgroundColor = "#9eb3c7";
					}
				}
			});
			div.addEventListener("click", ()=>{
				console.log(div.id);
				this.ShowQuestions(div.id);
			});
			
			let table = document.createElement("table");
			table.style.borderCollapse = "collapse";
			table.style.tableLayout = "fixed";
			table.style.width = "100%";
	
			let rowHeaders = document.createElement("tr");
			let rowData = document.createElement("tr");
	
			// Dokument-Symbol hinzufügen
			let columnSymbol = document.createElement("td");
			columnSymbol.className = "questionnaireHeader";
			columnSymbol.rowSpan = 2;
			columnSymbol.style.width = "50px";
			columnSymbol.style.fontSize = "40px";
			columnSymbol.style.textAlign = "center";
			columnSymbol.style.color = this.menuBarColor;
			columnSymbol.innerHTML = " &#128462;"; // 🗎
			columnSymbol.style.backgroundColor = "#9eb3c7";
	
			rowHeaders.append(columnSymbol);
			for (let index in questionnaire)
			{
				//console.log(response[questionnaire][index]);
				let columnHeaders = document.createElement("td");
				columnHeaders.className = "questionnaireHeader";
	
				// Änderung der Header-Bezeichnungen
				if (index == "name") columnHeaders.innerHTML = "Thema";
				else if (index == "zeitstempel") columnHeaders.innerHTML = "Datum";
				else if (index == "id") continue;
				else if (index == "anzfragen") continue;
				else if (index == "schueleranzahl") continue;
				else if (index == "klassenname") columnHeaders.innerHTML = "Klasse";
				else if (index == "fach") columnHeaders.innerHTML = "Fach";
				else if (index == "bewertungsumme") columnHeaders.innerHTML = "Punkte";
				else columnHeaders.innerHTML = index;
	
				columnHeaders.style.backgroundColor = "#9eb3c7";
				columnHeaders.style.fontWeight = "bold";
				columnHeaders.style.fontSize = "small";
				columnHeaders.style.color = this.menuBarColor;
				rowHeaders.appendChild(columnHeaders);
					
				let columnData = document.createElement("td");
	
				if (index == "zeitstempel")
				{
					let timestamp = questionnaire[index].split(" ");
					columnData.innerHTML = timestamp[0];
				}
				else columnData.innerHTML = questionnaire[index];
	
				rowData.appendChild(columnData);			
			}
	
			// Bogenstatus Header hinzufügen
			let columnStatusHeader = document.createElement("td");
			columnStatusHeader.className = "questionnaireHeader";
			columnStatusHeader.style.color = this.menuBarColor;
			columnStatusHeader.style.fontWeight = "bold";
			columnStatusHeader.style.fontSize = "small";
			columnStatusHeader.innerHTML = "Status";
			columnStatusHeader.style.backgroundColor = "#9eb3c7";
			rowHeaders.appendChild(columnStatusHeader);
	
			// Bogenstatus hinzufügen
			let columnStatus = document.createElement("td");
			columnStatus.style.fontWeight = "bold";
	
			//let formDataCodes = new FormData();
			//formDataCodes.append("fbId", questionnaire.id);

			// Synchroner Request
			//var responseQuestionnaireCodes = this.Request("./php/main.php?mode=getCodes", formDataCodes);
			
			// Asynchroner Request
			let xhttp = new XMLHttpRequest()
			let path = "./php/main.php?mode=getCodes";

			let formDataCodes = new FormData();
			formDataCodes.append("fbId", questionnaire.id);

			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					
					var responseQuestionnaireCodes = xhttp.responseText;
					// console.log("responseQuestionnaireCodes:");
					// console.log(responseQuestionnaireCodes);
	
					let codesArray = responseQuestionnaireCodes.split("},");
					//console.log(codesArray);
	
					if (codesArray != null && codesArray.length > 1)
					{
						columnStatus.innerHTML = "offen";
						columnStatus.style.color = "#feb460"; // orange
					}
					else
					{
						columnStatus.innerHTML = "abgeschlossen";
						columnStatus.style.color = "green";	
					}

					rowData.appendChild(columnStatus);
	
					// TODO: Matthias eine Issue-Nachricht auf GitHub schreiben, die Methode getCodes muss optimiert werden
					// Es darf nicht nur einfach eine Fehlermeldung kommen wenn es keine Codes für den Bogen gibt.
			
					div.appendChild(table);
					table.appendChild(rowHeaders);
					table.appendChild(rowData);
					
					
					questionnaireList.appendChild(div);
					questionnaireList.appendChild(document.createElement("br"));
					
				}
				//div.style.visibility = null;
			};
			xhttp.open("POST", path, true);
			xhttp.send(formDataCodes);

			/*
			// console.log("responseQuestionnaireCodes:");
			// console.log(responseQuestionnaireCodes);
	
			let codesArray = responseQuestionnaireCodes.split("},");
			//console.log(codesArray);
	
			if (codesArray != null && codesArray.length > 1)
			{
				columnStatus.innerHTML = "offen";
				columnStatus.style.color = "#feb460"; // orange
			}
			else
			{
				columnStatus.innerHTML = "abgeschlossen";
				columnStatus.style.color = "green";	
			}
	
			rowData.appendChild(columnStatus);
	
			// TODO: Matthias eine Issue-Nachricht auf GitHub schreiben, die Methode getCodes muss optimiert werden
			// Es darf nicht nur einfach eine Fehlermeldung kommen wenn es keine Codes für den Bogen gibt.
	
			table.appendChild(rowHeaders);
			table.appendChild(rowData);
			div.appendChild(table);
			questionnaireList.appendChild(div);
			
			// Event-Listener zum Hinzufügen der Fragen bei einem Klick auf den Bogen (Öffnen des Fragebogens)
			div.addEventListener("click", ()=>{
	
				this.ShowQuestions(div.id);
				/*
				for ( let i = 0; i < response.returnvalue[0].length; i++ )
				{
					// TODO: Iteration durch die Fragen um diese dem Bogen hinzuzufügen
					// - Warten auf Anpassung der Backend-Methode "getFbFragen" (die Kategorien müssen noch hinzugefügt werden)	
				}
				
				
			});
			*/
		}


	}

	Request(path, formData)
	{
		let response;
		let xhttp = new XMLHttpRequest();
		xhttp.open("POST", path, false);
		xhttp.send(formData);
		response = xhttp.responseText;

		//if (response.indexOf("{") != 0) return response;
		//if (response.length > 100 && response != null) return JSON.parse(response);
		return response;
	}

	ShowQuestions(questionnaireDiv)
	{
		let xhttp = new XMLHttpRequest()
		let path = "./php/main.php?mode=getFbFragen";

		let formData = new FormData();
		formData.append("fbId", questionnaireDiv.id);

		xhttp.onreadystatechange = ()=>{
			if ( xhttp.readyState == 4 && xhttp.status == 200 )
			{
		
				let response = JSON.parse(xhttp.responseText);
				console.log(response);
		
			}
		};
		xhttp.open("POST", path, true);
		xhttp.send(formData);
	}

}