//Popup za nas logo
document.getElementById("pokusaj").addEventListener('click', function(){
	document.querySelector(".bg-modal").style.display = "flex";
	document.getElementById("glavniFuter").setAttribute("hidden", "");
});

//Popup za korisnicki logo
document.getElementById("pokusaj1").addEventListener('click', function(){
	document.querySelector(".bg-modal1").style.display = "flex";
	document.getElementById("glavniFuter").setAttribute("hidden", "");
});

document.querySelector(".close").addEventListener('click', function(){
	document.querySelector(".bg-modal").style.display = "none";
	document.getElementById("glavniFuter").removeAttribute("hidden");
});

document.querySelector(".close1").addEventListener('click', function(){
	document.querySelector(".bg-modal1").style.display = "none";
	document.getElementById("glavniFuter").removeAttribute("hidden");
});

//Dugme na prvom popupu
document.querySelector(".ok").addEventListener('click', function(){
	document.querySelector(".bg-modal").style.display = "none";
	document.getElementById("glavniFuter").removeAttribute("hidden");
});

//Dugme na drugom popupu
document.querySelector(".ok1").addEventListener('click', function(){
	document.querySelector(".bg-modal1").style.display = "none";
	document.getElementById("glavniFuter").removeAttribute("hidden");
});


//Metoda za menjanje slika prilikom odabira naseg logoa
function OnGradeChanged(){
	var index = document.getElementById('selectLogo').value;

	if(index == 0){
		document.getElementById("slikaLogotipa").style.visibility = "hidden";
		document.getElementById("pokusaj1").disabled = false;
	}
	else{
		document.getElementById("slikaLogotipa").src="Images/logotip/logotip" + index + ".png";
		document.getElementById("slikaLogotipa").style.visibility = "visible";
		document.getElementById("pokusaj1").disabled = true;
	}
}

function OnClickReset1(){
	if(document.getElementById('selectLogo').value != 0){
		document.getElementById('selectLogo').value = 0;
		document.getElementById("pokusaj1").disabled = false;
		document.getElementById("slikaLogotipa").style.visibility = "hidden";
		document.getElementById("dodajUKorpu").disabled = true;
		document.getElementById("obavezanLogo").removeAttribute("hidden");
		document.getElementById("dodajUKorpu").className = "btn btn-danger";
		document.querySelector(".bg-modal").style.display = "none";
		document.getElementById("glavniFuter").removeAttribute("hidden");
	}
	else{
		document.querySelector(".bg-modal").style.display = "none";
		document.getElementById("glavniFuter").removeAttribute("hidden");
	}
}

function OnClickReset2(){
	if(fupload.files.length != 0){
		document.getElementById('fupload').value= null;
		document.getElementById("pokusaj").disabled = false;
		document.getElementById("dodajUKorpu").disabled = true;
		document.getElementById("obavezanLogo").removeAttribute("hidden");
		document.getElementById("dodajUKorpu").className = "btn btn-danger";
		document.querySelector(".bg-modal1").style.display = "none";
		document.getElementById("glavniFuter").removeAttribute("hidden");
	}
	else{
		document.querySelector(".bg-modal1").style.display = "none";
		document.getElementById("glavniFuter").removeAttribute("hidden");
	}
}

function OnChangeInput(){
	if(fupload.files.length != 0 ){
		document.getElementById("pokusaj").disabled = true;
	}
	else{
		document.getElementById("pokusaj").disabled = false;
	}
}

function OnClickIzaberiLogo1(){
	if(document.getElementById('selectLogo').value != 0) {
		document.getElementById("dodajUKorpu").disabled = false;
		document.getElementById("obavezanLogo").hidden = "true";
		document.getElementById("dodajUKorpu").className = "btn btn-success";
		document.querySelector(".bg-modal").style.display = "none";
		document.getElementById("glavniFuter").removeAttribute("hidden");
	}
	else{
		document.getElementById("dodajUKorpu").disabled = true;
		document.getElementById("obavezanLogo").removeAttribute("hidden");
		document.getElementById("dodajUKorpu").className = "btn btn-danger";
		document.querySelector(".bg-modal").style.display = "none";
		document.getElementById("glavniFuter").removeAttribute("hidden");
	}
}

function OnClickIzaberiLogo2(){
	if(fupload.files.length != 0){
		document.getElementById("dodajUKorpu").disabled = false;
		document.getElementById("obavezanLogo").hidden = "true";
		document.getElementById("dodajUKorpu").className = "btn btn-success";
		document.querySelector(".bg-modal1").style.display = "none";
		document.getElementById("glavniFuter").removeAttribute("hidden");
	}
	else{
		document.getElementById("dodajUKorpu").disabled = true;
		document.getElementById("obavezanLogo").removeAttribute("hidden");
		document.getElementById("dodajUKorpu").className = "btn btn-danger";
		document.querySelector(".bg-modal1").style.display = "none";
		document.getElementById("glavniFuter").removeAttribute("hidden");
	}
}

document.getElementById("dodajUKorpu").disabled = true;



