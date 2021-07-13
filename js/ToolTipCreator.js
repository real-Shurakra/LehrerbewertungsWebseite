// Klasse ToolTipCreator

export default class ToolTipCreator
{
	constructor()
	{
		this.svg;
		
		let path = "./svg/ToolTip.svg";
		let response;
		let xhttp = new XMLHttpRequest();
		
		xhttp.onreadystatechange = ()=>{
			if ( xhttp.readyState == 4 && xhttp.status == 200 )
			{
				response = xhttp.responseText;
				this.svg = response;
			}
		};
		xhttp.open("POST", path, true);
		xhttp.send();	
	}
	
	createToolTip(toolTipId, targetId)
	{
		let toolTip = document.createElement("div");
		toolTip.id = toolTipId;
		toolTip.style.position = "absolute";
		toolTip.style.height = "10px";
		toolTip.style.width = "20px";
		
		toolTip.innerHTML = this.svg;
		document.body.appendChild(toolTip);
		
		document.addEventListener("mousemove", (event)=>{
			let toolTipHeight =  parseInt(toolTip.style.height);
			let toolTipWidth = parseInt(toolTip.style.width);
			toolTip.style.top = event.clientY - 60 + "px";
			toolTip.style.left = window.innerWidth - (toolTipWidth + 180) + "px";
		});
		
		let target = document.getElementById(targetId);
		target.addEventListener("mouseenter", ()=>{
			if (toolTip != null) toolTip.style.visibility = "visible";
		});
		target.addEventListener("mouseleave", ()=>{
			if (toolTip != null) toolTip.style.visibility = "hidden";
		});
		
		return toolTip;
	}
}