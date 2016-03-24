/*
Simple Image Trail script- By JavaScriptKit.com
Visit http://www.javascriptkit.com for this script and more
This notice must stay intact
*/

var offsetfrommouse=[10,10]; //image x,y offsets from cursor position in pixels. Enter 0,0 for no offset
var displayduration=0; //duration in seconds image should remain visible. 0 for always.
var currentimageheight = 270;	// maximum image size.
var currentimagewidth = 270;	// maximum image size.


if (document.getElementById || document.all){
	document.write('<div id="trailimageid">');
	document.write('</div>');
}

function gettrailobj(){
if (document.getElementById)
return document.getElementById("trailimageid").style
else if (document.all)
return document.all.trailimagid.style
}

function gettrailobjnostyle(){
if (document.getElementById)
return document.getElementById("trailimageid")
else if (document.all)
return document.all.trailimagid
}


function truebody(){
return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function showtrail(imagename,title,description,showthumb,height,filetype,imagewidth,imageheight){

	if (height > 0){
		currentimageheight = height;
	}
	if (imageheight > 0){
		currentimageheight = imageheight;
	}
	if (imagewidth > 0){
		currentimagewidth = imagewidth;
	}

	document.onmousemove=followmouse;

	newHTML = '<div style="padding: 5px; background-color: #FFF; border: 1px solid #888;">';
	newHTML = newHTML + '<h2>' + title + '</h2>';
	newHTML = newHTML + description + '<br/>';

	if (showthumb > 0){
		newHTML = newHTML + '<div align="center" style="padding: 8px 2px 2px 2px;">';
		if(filetype == 8) { // Video
			newHTML = newHTML +	'<object width="380" height="285" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0">';
			newHTML = newHTML + '<param name="movie" value="video_loupe.swf">';
			newHTML = newHTML + '<param name="quality" value="best">';
			newHTML = newHTML + '<param name="loop" value="true">';

			newHTML = newHTML + '<param name="FlashVars" value="videoLocation=' + imagename + '&bufferPercent=25">';
			newHTML = newHTML + '<EMBED SRC="video_loupe.swf" LOOP="true" QUALITY="best" FlashVars="videoLocation=' + imagename + '&bufferPercent=25" WIDTH="380" HEIGHT="285">';
			newHTML = newHTML + '</object></div>';
		} else {
			if (imagewidth > 0 && imageheight > 0){
				newHTML = newHTML + '<img src="' + imagename + '" border="0" height="'+imageheight+'" width="'+imagewidth+'" ></div>';
			}
			else{
				newHTML = newHTML + '<img src="' + imagename + '" border="0"></div>';
			}
		}
	}

	newHTML = newHTML + '</div>';
	gettrailobjnostyle().innerHTML = newHTML;
	gettrailobj().display="inline";
}



function hidetrail(){
	gettrailobj().innerHTML = " ";
	gettrailobj().display="none"
	document.onmousemove=""
	gettrailobj().left="-500px"

}

function showzoom(imagename,title,description,showthumb,height,filetype,imagewidth,imageheight){

	if (height > 0){
		currentimageheight = height;
	}
	if (imageheight > 0){
		currentimageheight = imageheight;
	}
	if (imagewidth > 0){
		currentimagewidth = imagewidth;
	}

	//document.onmousemove=followmouse;

	var docwidth=document.all? truebody().scrollLeft+truebody().clientWidth : pageXOffset+window.innerWidth-15
	var docheight=document.all? Math.min(truebody().scrollHeight, truebody().clientHeight) : Math.min(window.innerHeight)

    var scrollX,scrollY;
	if (document.all)
	{
		if (!document.documentElement.scrollTop)
		{
			scrollY = document.body.scrollTop;
		}
		else
		{
			scrollY = document.documentElement.Top;
		}
	}
	else
	{
		scrollY = window.pageYOffset;
	}



//	alert (scrollY);
//	alert (window.pageYOffset);
//	alert (document.body.scrolltop);
//	alert (document.documentelement.scrolltop);
//	alert (document.all? window.screenTop : window.pageYOffset);
	
	gettrailobj().left = (docwidth/2)<(currentimagewidth/2)?0:(docwidth/2)-(currentimagewidth/2)
	gettrailobj().top = ((docheight/2)<(currentimageheight/2)?0:(docheight/2)-(currentimageheight/2)) + scrollY
//	window.pageYOffset
	gettrailobj().width = currentimagewidth
	gettrailobj().height = currentimageheight


	newHTML = '<div style="padding: 5px; background-color: #FFF; border: 1px solid #888;">';
	newHTML = newHTML + '<div align="Left"><a href="javascript:hidetrail()">[Close Zoom]<a/></div>';
//	newHTML = newHTML + '<h2>' + title + '</h2>';
//	newHTML = newHTML + description + '<br/>';

	if (showthumb > 0){
		newHTML = newHTML + '<div align="center" style="padding: 8px 2px 2px 2px;">';
		if(filetype == 8) { // Video
			newHTML = newHTML +	'<object width="380" height="285" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0">';
			newHTML = newHTML + '<param name="movie" value="video_loupe.swf">';
			newHTML = newHTML + '<param name="quality" value="best">';
			newHTML = newHTML + '<param name="loop" value="true">';

			newHTML = newHTML + '<param name="FlashVars" value="videoLocation=' + imagename + '&bufferPercent=25">';
			newHTML = newHTML + '<EMBED SRC="video_loupe.swf" LOOP="true" QUALITY="best" FlashVars="videoLocation=' + imagename + '&bufferPercent=25" WIDTH="380" HEIGHT="285">';
			newHTML = newHTML + '</object></div>';
		} else {
			if (imagewidth > 0 && imageheight > 0){
				newHTML = newHTML + '<img src="' + imagename + '" border="0" height="'+imageheight+'" width="'+imagewidth+'" ></div>';
			}
			else{
				newHTML = newHTML + '<img src="' + imagename + '" border="0"></div>';
			}
		}
	}

	newHTML = newHTML + '</div>';
	gettrailobjnostyle().innerHTML = newHTML;
	gettrailobj().display="inline";
}


function followmouse(e){

	var xcoord=offsetfrommouse[0]
	var ycoord=offsetfrommouse[1]

	var docwidth=document.all? truebody().scrollLeft+truebody().clientWidth : pageXOffset+window.innerWidth-15
	var docheight=document.all? Math.min(truebody().scrollHeight, truebody().clientHeight) : Math.min(window.innerHeight)

	//if (document.all){
	//	gettrailobjnostyle().innerHTML = 'A = ' + truebody().scrollHeight + '<br>B = ' + truebody().clientHeight;
	//} else {
	//	gettrailobjnostyle().innerHTML = 'C = ' + document.body.offsetHeight + '<br>D = ' + window.innerHeight;
	//}


    //Netscape
 	if (typeof e != "undefined"){
		if (docwidth - e.pageX < 380){
			xcoord = e.pageX - xcoord - (currentimagewidth+20 + offsetfrommouse[0]); // Move to the left side of the cursor
		} else {
			xcoord += e.pageX;
		}
		if (docheight - e.pageY < (currentimageheight + 110)){
			ycoord += e.pageY - Math.max(0,(110 + currentimageheight + e.pageY - docheight - truebody().scrollTop));
		} else {
			ycoord += e.pageY;
		}
    //IE5+
	} else if (typeof window.event != "undefined"){
		if (docwidth - event.clientX < 380){
			xcoord = event.clientX + truebody().scrollLeft - xcoord - (currentimagewidth+20 + offsetfrommouse[0]); // Move to the left side of the cursor
		} else {
			xcoord += truebody().scrollLeft+event.clientX
		}
		if (docheight - event.clientY < (currentimageheight + 110)){
			ycoord += event.clientY + truebody().scrollTop - Math.max(0,(110 + currentimageheight + event.clientY - docheight));
		} else {
			ycoord += truebody().scrollTop + event.clientY;
		}
	}

	var docwidth=document.all? truebody().scrollLeft+truebody().clientWidth : pageXOffset+window.innerWidth+1000
	var docheight=document.all? Math.max(truebody().scrollHeight, truebody().clientHeight) : Math.max(document.body.offsetHeight, window.innerHeight)
	if(ycoord < 0) { ycoord = ycoord*-1; }

    if (document.all){
		gettrailobj().width = currentimagewidth - 20
	}
	else{
		gettrailobj().width = currentimagewidth + 20
	}
	
	
	gettrailobj().left=xcoord+"px"
	gettrailobj().top=ycoord+"px"

}

