function colorPicker(){
	hue = document.getElementById('hue').value;
	sat = document.getElementById('saturation').value;
	lum = document.getElementById('luminosity').value;
	alp = document.getElementById('alpha').value;

	hsl    = 'hsl('+hue+', '+sat+'%, '+lum+'%)';
	hsla   = 'hsla('+hue+', '+sat+'%, '+lum+'%, '+alp+')';
	hslSat = 'hsl('+hue+', 100%, '+lum+'%)';
	hslLum = 'hsl('+hue+', '+sat+'%, 50%)';
	
	if(alp == '1'){
		document.getElementById('result').innerHTML = hsl;
	}
	else{
		document.getElementById('result').innerHTML = hsla;
	}
	document.getElementById('color-display').style.backgroundColor = hsla;
	document.getElementById('saturation').style.backgroundImage = 'linear-gradient(to right, hsl(0, 0%, 50%), '+hslSat+')';
	document.getElementById('luminosity').style.backgroundImage = 'linear-gradient(to right, #000, '+hslLum+', #fff)';
	document.getElementById('alpha').style.backgroundColor = hsl;
	
}