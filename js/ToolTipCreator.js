// Klasse ToolTipCreator

export default class ToolTipCreator
{
	constructor()
	{

	}
	
	createToolTip(imageFilename, toolTipId, targetId)
	{
		let target = document.getElementById(targetId);
		console.log(target);
		let rect = target.getBoundingClientRect();
		console.log(rect.top, rect.right, rect.bottom, rect.left);
		
		let toolTip = document.createElement("div");
		toolTip.style.position = "absolute";
		toolTip.style.height = "60px";
		toolTip.style.width = "120px";
		toolTip.style.display = "inline";
		toolTip.style.background = "url('./html/" + imageFilename + ".png') no-repeat";
		toolTip.style.backgroundSize = "contain";
		
		if(toolTipId.includes("right"))
		{
			toolTip.style.left = rect.right - 35 + "px";
			toolTip.style.top = rect.top - parseInt(toolTip.style.height) - 12 + "px";
			toolTip.style.fontWeight = "bold";
			toolTip.style.padding = "15px";
			toolTip.style.textAlign = "right";
			toolTip.innerText = "✓ all";
		}
		if(toolTipId.includes("left"))
		{
			toolTip.style.left = rect.left + 35 - parseInt(toolTip.style.width) + "px";
			toolTip.style.top = rect.top - parseInt(toolTip.style.height) - 12 + "px";
			toolTip.style.fontWeight = "bold";
			toolTip.style.padding = "15px";
			toolTip.style.textAlign = "left";
			toolTip.innerText = " one ✓";
		}
		
		document.body.appendChild(toolTip);

		target.addEventListener("mouseenter", ()=>{
			if (toolTip != null) toolTip.style.visibility = "visible";

		});
		target.addEventListener("mouseleave", ()=>{
			if (toolTip != null) toolTip.style.visibility = "hidden";

		});
		
		return toolTip;

	}
}