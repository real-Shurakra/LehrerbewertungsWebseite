// Klasse Page

export default class Page
{
	constructor(id)
	{
		this.id = id;
		this.addHTML();
	}
	
	// Funktion um Daten nachzuladen und der Page hinzuzufügen
	addHTML()
	{
		let path = "./html/" + this.id + ".html";
		let xhttp = new XMLHttpRequest();
		let innerHTML = "";
		var domElement = document.getElementById(domId);
		
		xhttp.onreadystatechange = ()=>{
			if (xhttp.readyState == 4 && xhttp.status == 200)
			{
				domElement.innerHTML = xhttp.responseText;
			}
		};
		if (domElement != null)
		{
			xhttp.open("POST", path, true);
			xhttp.send();
		}

	}
}