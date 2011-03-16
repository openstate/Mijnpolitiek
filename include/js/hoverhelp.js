function showHelpFloatWindow(windowID, obj, horizPadding, vertPadding, goRight)
{
	var w = document.getElementById(windowID);
	if (w != null)
	{	
		w.style.display = 'block';
		w.style.visibility = 'visible';
		
		w.style.top = getAscendingTops(obj) + vertPadding;
		
		if (getAscendingTops(obj) + vertPadding < 0) w.style.top = 0;
		
		if (goRight == true)
			w.style.left = getAscendingLefts(obj) + obj.offsetWidth + horizPadding;
		else
		{
			w.style.left = getAscendingLefts(obj) - horizPadding;
			if ((getAscendingLefts(obj) - horizPadding) < 0) w.style.left = getAscendingLefts(obj) + obj.offsetWidth + horizPadding;
		}
	}
}


function hideHelpFloatWindow(windowID)
{
	var w = document.getElementById(windowID);
	if (w != null)
	{
		w.style.display = 'none';
		w.style.visibility = 'hidden';
		
		w.top = -999;
		w.left = -999;
	}
}

function getAscendingLefts(elem){
	if (elem==null)
		return 0;
	else
		return elem.offsetLeft+getAscendingLefts(elem.offsetParent);
}

function getAscendingTops(elem){
	if (elem==null)
		return 0;
	else
		return elem.offsetTop+getAscendingTops(elem.offsetParent);
}