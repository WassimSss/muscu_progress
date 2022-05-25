var getHttpRequest = function() {
	var httpRequest = false;

	if (window.XMLHttpRequest) {
		// Mozilla, Safari,...
		httpRequest = new XMLHttpRequest();
		if (httpRequest.overrideMimeType) {
			httpRequest.overrideMimeType('text/xml');
		}
	} else if (window.ActiveXObject) {
		// IE
		try {
			httpRequest = new ActiveXObject('Msxml2.XMLHTTP');
		} catch (e) {
			try {
				httpRequest = new ActiveXObject('Microsoft.XMLHTTP');
			} catch (e) {}
		}
	}

	if (!httpRequest) {
		alert('Abandon :( Impossible de créer une instance XMLHTTP');
		return false;
	}

	return httpRequest;
};

var addMuscle = document.getElementById('choise_muscle');
var addExercise = document.getElementById('choise_exercise');
var addRepetition = document.getElementById('choise_repetition');
var addWeight = document.getElementById('choise_weight');
var buttonSumbitDay = document.getElementById('submit_day_session');
var testButton = document.getElementById('test');
var allContain = document.querySelector('.all_contain');
var dayRecap = document.querySelector('.all_for_muscle');
var idUser = document.getElementById('id_user');
var allForMuscleSolo = document.getElementsByClassName('all_for_muscle_solo');
var allForMuscleSoloQuery = document.querySelectorAll('.all_for_muscle_solo');
const calendar = document.querySelector('.calendar');
const sessionCalendar = document.querySelector('.session_calendar');
var allDaysWorked = [];
var jsonAllSessionDay;
let jsonAllDayWorked;
var showMore = document.querySelector('.show_more');
var dateClicked;
var sessionForDay = document.querySelector('.session');

//color sccs variable (a mettre dans un tableau)
var redplus = '#AF1717';

var httpRequest = getHttpRequest();

function allUniqueValuesInArray(array) {
	// Créer un array sans les muscles en doublon de la bdd
	var uniqueValues = [];

	for (let i = 0; i < array.length; i++) {
		var input = Object.values(array[i]); //Cibler tout les inputs entrée (ligne dans base de donné)
		if (!uniqueValues.includes(input[2])) {
			//Parcours tout les muscles et regarde si il est dans muscleBddUnique
			uniqueValues.push(input[2]); // Si il n'y est pas on l'ajoute
		}
	}
	return uniqueValues;
}

function addHTMLTitleMuscle(jsonObj, nameClass, divPasting, theadActivated = false) {
	// Fonction qui ajoute un titre en fonction du tableau json, avec les valeurs unique de allUniqueValuesInArray()
	var allUniqueMuscles = allUniqueValuesInArray(jsonObj); // Tout les Muscles unique

	for (let j = 0; j < allUniqueMuscles.length; j++) {
		// Parcours tout les Muscles Unique et crée des div
		var allForMuscleDiv = document.createElement('div');
		allForMuscleDiv.classList.add(nameClass);
		var muscleNameCss = allUniqueMuscles[j].replaceAll(' ', '_'); //Permet d'avoir un nom lisible en css
		if (muscleNameCss.search('-')) {
			muscleNameCss = muscleNameCss.replaceAll('-', '_');
		}
		if (theadActivated) {
			muscleNameCss = `muscleday_${muscleNameCss}`;
		} else {
			muscleNameCss = `muscle_${muscleNameCss}`;
		}
		allForMuscleDiv.id = muscleNameCss;
		divPasting.appendChild(allForMuscleDiv);

		var titleMuscle = document.createElement('h3');
		titleMuscle.classList.add('red');
		titleMuscle.innerHTML = allUniqueMuscles[j].replaceAll('_', ' ');
		allForMuscleDiv.appendChild(titleMuscle);

		if (theadActivated) {
			const thead = `
				<div class="t_head">
					<ul>
						<li class="title_in_day">Exercice</li>
						<li class="series_in_day">Séries</li>			
						<li class="weight_in_day">Poids</li>
						<li class="repetition_in_day">Répétitions</li>
					</ul>
				</div>
			`;
			titleMuscle.insertAdjacentHTML('afterend', thead);
		}
	}
}

function addOneHTMLTitleMuscle(postJsonObj) {
	//Ajoute seulement une ligne pour la methode post //fetchBdd -> result get / postJsonObj -> result post
	var allForMuscleDiv = document.createElement('div');
	allForMuscleDiv.classList.add('all_for_muscle_solo');
	var muscleNameCss = postJsonObj['muscle'].replaceAll(' ', '_'); //Permet d'avoir un nom lisible en css
	if (muscleNameCss.search('-')) {
		muscleNameCss = muscleNameCss.replaceAll('-', '_');
	}
	muscleNameCss = `muscle_${muscleNameCss}`;
	allForMuscleDiv.id = muscleNameCss;
	dayRecap.appendChild(allForMuscleDiv);

	var titleMuscle = document.createElement('h3');
	titleMuscle.classList.add('red');
	titleMuscle.innerHTML = postJsonObj['muscle'].replaceAll('_', ' ');
	allForMuscleDiv.appendChild(titleMuscle);
}

function addHTMLTitleExercise(jsonObj, ulModeActivated = false) {
	// Créer le titre exercise
	for (let i = 0; i < jsonObj.length; i++) {
		var line = jsonObj[i]; //Regarde ligne par ligne dans la base de donné
		var exerciceNameCss = `${line['muscle']}_${line['nom_exercise']}`.replaceAll(' ', '_'); //Permet d'avoir un nom lisible en css
		if (exerciceNameCss.search('-')) {
			exerciceNameCss = exerciceNameCss.replaceAll('-', '_');
		}
		if (ulModeActivated) {
			exerciceNameCss = `exerciseday_${exerciceNameCss}`;
		} else {
			exerciceNameCss = `exercise_${exerciceNameCss}`;
		}

		if (document.getElementById(exerciceNameCss) == null) {
			//Si existe pas de div avec l'id de l'exercise on crée comme ça on en a que 1
			if (ulModeActivated) {
				var exerciseDiv = document.createElement('div');
				exerciseDiv.classList.add('one_exercice_for_muscle');
				exerciseDiv.id = exerciceNameCss;
				document.getElementById(`muscleday_${line['muscle']}`).appendChild(exerciseDiv);

				var ulAllSeries = document.createElement('ul');
				ulAllSeries.classList.add('all_series');
				ulAllSeries.id = `exerciceday_${i}`;
				exerciseDiv.appendChild(ulAllSeries);

				var liFirst = document.createElement('li');
				liFirst.classList.add('first');
				ulAllSeries.append(liFirst);

				var ulForFirst = document.createElement('ul');
				liFirst.appendChild(ulForFirst);

				var liTitleDay = document.createElement('li');
				liTitleDay.classList.add('title_in_day');
				liTitleDay.innerHTML = line['nom_exercise'].replaceAll('_', ' ');
				ulForFirst.appendChild(liTitleDay);

				var liSeriesDay = document.createElement('li');
				liSeriesDay.classList.add('series_in_day');
				liSeriesDay.innerHTML = '01';
				ulForFirst.appendChild(liSeriesDay);

				var liWeightDay = document.createElement('li');
				liWeightDay.classList.add('weight_in_day');
				liWeightDay.innerHTML = line['poids'];
				ulForFirst.appendChild(liWeightDay);

				var spanKg = document.createElement('span');
				spanKg.classList.add('red');
				spanKg.innerHTML = ' kg';
				liWeightDay.appendChild(spanKg);

				var liRepetitionDay = document.createElement('li');
				liRepetitionDay.classList.add('repetition_in_day');
				liRepetitionDay.innerHTML = line['repetition'];
				ulForFirst.appendChild(liRepetitionDay);

				var liShowMore = document.createElement('li');
				liShowMore.classList.add('show_more');
				liShowMore.id = `show_more_${i}`;
				liShowMore.innerHTML = `<ion-icon name="chevron-down-outline"></ion-icon>`;
				ulForFirst.appendChild(liShowMore);

				var divOther = document.createElement('div');
				divOther.classList.add('other');
				ulAllSeries.appendChild(divOther);

				// Pour afficher 1 fois en plus

				var liDayHidden = document.createElement('li');
				divOther.appendChild(liDayHidden);
				var ulDivHiddenOne = document.createElement('ul');
				liDayHidden.appendChild(ulDivHiddenOne);

				var liTitleHidden = document.createElement('li');
				liTitleHidden.classList.add('title_in_day');
				ulDivHiddenOne.appendChild(liTitleHidden);

				var liSeriesHidden = document.createElement('li');
				liSeriesHidden.classList.add('series_in_day');
				ulDivHiddenOne.appendChild(liSeriesHidden);

				var liWeightHidden = document.createElement('li');
				liWeightHidden.classList.add('weight_in_day');
				liWeightHidden.innerHTML = line['poids'];
				ulDivHiddenOne.appendChild(liWeightHidden);
				
				var spanKg = document.createElement('span');
				spanKg.classList.add('red');
				spanKg.innerHTML = ' kg';
				liWeightHidden.appendChild(spanKg);

				var liRepetitionHidden = document.createElement('li');
				liRepetitionHidden.classList.add('repetition_in_day');
				liRepetitionHidden.innerHTML = line['repetition'];
				ulDivHiddenOne.appendChild(liRepetitionHidden);
			} else {
				var exerciseDiv = document.createElement('div');
				exerciseDiv.classList.add('exercise');
				exerciseDiv.id = exerciceNameCss;
				document.getElementById(`muscle_${line['muscle']}`).appendChild(exerciseDiv); // Ajout de l'exercise en fonction dans l'id de son muscle

				var titleExercise = document.createElement('p');
				titleExercise.classList.add('title_exercise');
				titleExercise.innerHTML = line['nom_exercise'].replaceAll('_', ' ');
				document.getElementById(exerciceNameCss).appendChild(titleExercise);

				addHTMLLineExericise(line, exerciceNameCss);
			}
		} else {
			if (ulModeActivated) {
				
				var liDayHidden = document.createElement('li');
				divOther.appendChild(liDayHidden);

				var ulDivHiddenOne = document.createElement('ul');
				liDayHidden.appendChild(ulDivHiddenOne);

				var liTitleHidden = document.createElement('li');
				liTitleHidden.classList.add('title_in_day');
				ulDivHiddenOne.appendChild(liTitleHidden);

				var liSeriesHidden = document.createElement('li');
				liSeriesHidden.classList.add('series_in_day');
				ulDivHiddenOne.appendChild(liSeriesHidden);

				var liWeightHidden = document.createElement('li');
				liWeightHidden.classList.add('weight_in_day');
				liWeightHidden.innerHTML = line['poids'];
				ulDivHiddenOne.appendChild(liWeightHidden);

				var spanKg = document.createElement('span');
				spanKg.classList.add('red');
				spanKg.innerHTML = ' kg';
				liWeightHidden.appendChild(spanKg);

				var liRepetitionHidden = document.createElement('li');
				liRepetitionHidden.classList.add('repetition_in_day');
				liRepetitionHidden.innerHTML = line['repetition'];
				ulDivHiddenOne.appendChild(liRepetitionHidden);

				liSeriesDay.innerHTML = divOther.childElementCount
			} else {
				addHTMLLineExericise(line, exerciceNameCss);
			}
		}
	}
}

function addOneHTMLTitleExercice(postJsonObj) {
	var exerciceNameCss = `${postJsonObj['muscle']}_${postJsonObj['nom_exercise']}`.replaceAll(' ', '_'); //Permet d'avoir un nom lisible en css
	if (exerciceNameCss.search('-')) {
		exerciceNameCss = exerciceNameCss.replaceAll('-', '_');
	}

	exerciceNameCss = `exercise_${exerciceNameCss}`;

	var exerciseDiv = document.createElement('div');
	exerciseDiv.classList.add('exercise');
	exerciseDiv.id = exerciceNameCss;
	document.getElementById(`muscle_${postJsonObj['muscle']}`).appendChild(exerciseDiv); // Ajout de l'exercise en fonction dans l'id de son muscle

	var titleExercise = document.createElement('p');
	titleExercise.classList.add('title_exercise');
	titleExercise.innerHTML = postJsonObj['nom_exercise'].replaceAll('_', ' ');
	document.getElementById(exerciceNameCss).appendChild(titleExercise);

	// addHTMLLineExericise(line, exerciceNameCss);
	// } else {
	//   addHTMLLineExericise(line, exerciceNameCss);
	// }
}

function addHTMLLineExericise(line, exerciceNameCss) {
	// Créer les séries
	var lineExercise = document.createElement('div');
	lineExercise.classList.add('line_exercise', `id${line['id']}`);
	lineExercise.classList.add();
	document.getElementById(exerciceNameCss).insertAdjacentElement('beforeend', lineExercise);

	var sessionNumber = document.createElement('p');
	sessionNumber.innerHTML = `Série`; //`Série ${numberSession}`
	// sessionNumberBoucle++;
	lineExercise.appendChild(sessionNumber);

	var weightNumber = document.createElement('p');
	weightNumber.innerHTML = line['poids'].replaceAll('_', ' ');
	lineExercise.appendChild(weightNumber);

	var spanKg = document.createElement('span');
	spanKg.classList.add('red');
	spanKg.innerHTML = 'kg';
	weightNumber.appendChild(spanKg);

	var repetitionNumber = document.createElement('p');
	repetitionNumber.innerHTML = line['repetition'].replaceAll('_', ' ');
	lineExercise.appendChild(repetitionNumber);

	var buttonLogoDelete = document.createElement('button');
	buttonLogoDelete.classList.add(`delete_logo`, `delete_logoid${line['id']}`);
	lineExercise.appendChild(buttonLogoDelete);

	// var logoDelete = document.createElement('ion-icon');
	// logoDelete.setAttribute("name","close-outline");
	// logoDelete.classList.add(`delete_logo${line['id']}`)
	// buttonLogoDelete.appendChild(logoDelete);

	// var test = document.createElement('p');
	// test.innerHTML = line['poids'].replaceAll('_',' ');
}

function addOneHTMLLineExercise(postJsonObj) {
	var lineExercise = document.createElement('div');
	lineExercise.classList.add('line_exercise');
	document
		.getElementById(`exercise_${postJsonObj['muscle']}_${postJsonObj['nom_exercise']}`)
		.insertAdjacentElement('beforeend', lineExercise);

	var sessionNumber = document.createElement('p');
	sessionNumber.innerHTML = `Série`; // sessionNumber.innerHTML = `Série ${i}` //`Série ${numberSession}`
	// sessionNumberBoucle++;
	lineExercise.appendChild(sessionNumber);

	var weightNumber = document.createElement('p');
	weightNumber.innerHTML = postJsonObj['poids'].replaceAll('_', ' ');
	lineExercise.appendChild(weightNumber);

	var spanKg = document.createElement('span');
	spanKg.classList.add('red');
	spanKg.innerHTML = 'kg';
	weightNumber.appendChild(spanKg);

	var repetitionNumber = document.createElement('p');
	repetitionNumber.innerHTML = postJsonObj['repetition'].replaceAll('_', ' ');
	lineExercise.appendChild(repetitionNumber);

	var buttonLogoDelete = document.createElement('button');
	buttonLogoDelete.classList.add(`delete_logo`, `delete_logoid${postJsonObj['id']}`);
	lineExercise.appendChild(buttonLogoDelete);

	buttonLogoDelete.addEventListener('click', function() {
		document
			.getElementById(`exercise_${postJsonObj['muscle']}_${postJsonObj['nom_exercise']}`)
			.removeChild(lineExercise);

		var httpRequest = getHttpRequest();

		httpRequest.onreadystatechange = function() {
			if (httpRequest.readyState === 4) {
				if (httpRequest.status === 200) {
					var result = JSON.parse(httpRequest.response);
				} else {
					alert('impossible de contacterle serveur');
				}
			}
		};

		httpRequest.open('POST', '../config/deleteLineExercise.php', true);
		var data = new FormData();
		data.append('classId', postJsonObj['id']);
		httpRequest.send(data);
	});
}

function deleteAllDiv(parent, deleteClassName) {
	// Choisi un parent qui va contenir plusieur div avec la class qu'on entre dans le parametre deleteClassName
	var div = parent; //Parent
	var allDivDeleted = document.querySelectorAll(`.${deleteClassName}`);
	for (let i = 0; i < allDivDeleted.length; i++) {
		div.removeChild(allDivDeleted[i]);
	}
}

function deleteDiv(parent, deleteClassName) {
	// Choisi un parent qui va contenir plusieur div avec la class qu'on entre dans le parametre deleteClassName
	var div = parent; //Parent
	var allDivDeleted = document.querySelector(`.${deleteClassName}`);
	div.removeChild(allDivDeleted);
}

function loadCalendar(allDays = '') {
	const date = new Date(); //new Date(2022, 1, 22)

	const numberDay = date.getDay() + 1; // entre 0 et 6 => quand le jour commence, en anglais, il faut faire + 1
	const day = date.getDate(); // jour de aujourd'hui
	const month = date.getMonth(); // mois d'aujourd'hui
	const year = date.getFullYear();

	var monthAndYear = document.createElement('div');
	monthAndYear.classList.add('month_and_year');
	sessionCalendar.insertBefore(monthAndYear, calendar);

	var monthAndYearText = document.createElement('h2');
	monthAndYearText.style.margin = '5px';
	monthAndYear.appendChild(monthAndYearText);

	var monthSpanRed = document.createElement('span');
	monthSpanRed.classList.add('red');

	var options = { month: 'long' };

	let monthText = new Intl.DateTimeFormat('fr-FR', options).format(date);
	monthText = monthText.charAt(0).toUpperCase() + monthText.slice(1);
	monthSpanRed.innerHTML = monthText;
	monthAndYearText.appendChild(monthSpanRed);

	let yearText = document.createElement('span');
	yearText.classList.add('white');
	yearText.innerHTML = ' ' + year;
	monthAndYearText.appendChild(yearText);

	//Precedent
	const pastDaysInMonth = new Date(year, month, 0).getDate(); //Nombre de jour du mois precedent

	//Maintenant
	const firstDayInMonth = new Date(year, month, 1).getDay(); //Jour ou commence le mois de maintenant entre 0 et 6

	const daysInMonth = new Date(year, month + 1, 0).getDate(); //Nombre de jour de se mois // month + 1 car on commence au mois 0, // 3eme parametre c le nombre de jour, jour 0 c'est lonc le dernier jour du mois, ce
	let getMonth = new Date(year, month, 1).getMonth();
	let getYear = new Date(year, month, 1).getFullYear();
	//Après
	// const test = new Date(year, month + 1, 1) //Jour ou commence le mois d'apres entre 0 et 6
	const afterDaysInMonth = new Date(year, month + 1, 0); //Nombre de jour de se mois // month + 1 car on commence au mois 0, // 3eme parametre c le nombre de jour, jour 0 c'est lonc le dernier jour du mois, ce

	// Voir le mois commence a quel jour pour mettre les jours du mois d'avant
	let numberDayInPastMonth = pastDaysInMonth - (firstDayInMonth - 1); // premier jour a afficherdu mois precedent // -1 car de 0 a 6 // Au debut c'etait a -2 j'ai mis -1
	// Precedent
	let jumpCase;
	switch (firstDayInMonth) {
		case 0: // Dimanche, il faut sauter 6 case
			jumpCase = 6;
			break;
		case 1: // Lundi, 0 case
			jumpCase = 0;
			break;
		case 2: // Mardi, 1 case
			jumpCase = 1;
			break;
		case 3:
			jumpCase = 2;
			break;
		case 4:
			jumpCase = 3;
			break;
		case 5:
			jumpCase = 4;
			break;
		case 6:
			jumpCase = 5;
			break;

		default:
			break;
	}

	switch (getMonth) {
		case 0: // Janvier
			getMonth = '01';
			break;
		case 1: // Fevrier
			getMonth = '02';
			break;
		case 2: // Mars
			getMonth = '03';
			break;
		case 3:
			getMonth = '04';
			break;
		case 4:
			getMonth = '05';
			break;
		case 5:
			getMonth = '06';
			break;
		case 6:
			getMonth = '07';
			break;
		case 7:
			getMonth = '08';
			break;
		case 8:
			getMonth = '09';
			break;
		case 9:
			getMonth = '10';
			break;
		case 10:
			getMonth = '11';
			break;
		case 11:
			getMonth = '12';
			break;

		default:
			break;
	}
	// alert(jumpCase)
	for (let i = 1; i <= jumpCase; i++) {
		// Pour le nombre de jour du mois precedent - la place disponible, si le mois actuelle commence un vendredi, il y aura 5 case avant, a remplir avec l'ancien mois
		var calendarChild = document.createElement('div');
		calendarChild.classList.add('calendar_child');
		calendar.appendChild(calendarChild);

		var calendarChildText = document.createElement('p');
		calendarChildText.classList.add('grey');
		if (jumpCase != 6) {
			calendarChildText.innerHTML = numberDayInPastMonth + 1;
			numberDayInPastMonth++;
		} else {
			// alert("ok")
			calendarChildText.innerHTML = numberDayInPastMonth - jumpCase;
			numberDayInPastMonth++;
		}
		// calendarChildText.innerHTML = numberDayInPastMonth + 1;
		// numberDayInPastMonth++;
		calendarChild.appendChild(calendarChildText);
	}
	//Ce mois ci
	for (let i = 1; i < daysInMonth + 1; i++) {
		//

		var calendarChild = document.createElement('div');
		calendarChild.classList.add('calendar_child');
		calendar.appendChild(calendarChild);

		var calendarChildText = document.createElement('p');
		if (i == day) {
			calendarChildText.classList.add('red');
		}
		for (let j = 0; j < allDays.length; j++) {
			if (
				i == parseInt(allDays[j].slice(0, 2)) &&
				getMonth == allDays[j].slice(3, 5) &&
				getYear == allDays[j].slice(6, 10)
			) {
				calendarChild.style.backgroundColor = redplus;
				// calendarChild.remove("calendar_child")
				calendarChild.classList.add(`date_${allDays[j].slice(0, 2)}.${getMonth}.${getYear}`, 'active');
				calendarChildText.classList.add(`date_${allDays[j].slice(0, 2)}.${getMonth}.${getYear}`);
				// calendarChild.classList.add('calendar_child');  // Pour que la date sois en premier
			}
		}
		calendarChildText.innerHTML = i;
		calendarChild.appendChild(calendarChildText);
	}

	//Mettre les case en rouge pour les jours travailler

	let gridRest = jumpCase + daysInMonth; //Il y a 42 colonne dans la grille, 42 - ( nbr mois precedent + nb du mois de mtn )
	for (let i = 1; gridRest <= 42 - 1; i++) {
		var calendarChild = document.createElement('div');
		calendarChild.classList.add('calendar_child');
		calendar.appendChild(calendarChild);

		var calendarChildText = document.createElement('p');
		calendarChildText.classList.add('grey');
		calendarChildText.innerHTML = i; // Numero du jour
		numberDayInPastMonth++;
		calendarChild.appendChild(calendarChildText);
		gridRest++;
	}

	thisDayWorked();
}

function thisDayWorked() {
	var allActive = document.querySelectorAll('.active');

	for (let a = 0; a < allActive.length; a++) {
		allActive[a].addEventListener('click', function(e) {
			for (let test = 0; test < e.target.classList.length; test++) {
				if (e.target.classList[test].includes('date')) {
					dateClicked = e.target.classList[test].replaceAll('date_', '');
					document.querySelector(".text_date").innerHTML = dateClicked.replaceAll(".","/");
				}
			}
			httpRequest.onreadystatechange = () => {
				if (httpRequest.readyState == 4) {
					thisDayWorked = JSON.parse(httpRequest.response);
					thisDayWorked = thisDayWorked.reverse();
					sessionForDay.innerHTML = '';
					addHTMLTitleMuscle(thisDayWorked, 'one_muscle', sessionForDay, true);
					addHTMLTitleExercise(thisDayWorked, true);
					showMore = document.querySelectorAll('.show_more');
					for (let button = 0; button < showMore.length; button++) {
						showMore[button].addEventListener('click', function(e) {
							let whereActive = showMore[button].getAttribute('id').replace('show_more_', 'exerciceday_');
							document.getElementById(whereActive).classList.toggle('active');
						});
					}

					// document.querySelector(".session_in_day").innerHTML = thisDayWorked;
				}
			};
			httpRequest.open('GET', `../config/fetchExerciceInDay.php?test=${dateClicked}`, true);
			httpRequest.send();
		});
	}
}

function fetchAllDayWorked() {
	// Va etre lancer apres le chargement de fetchJsonObj
	httpRequest.onreadystatechange = () => {
		if (httpRequest.readyState == 4) {
			jsonAllDayWorked = JSON.parse(httpRequest.response);
			for (let i = 0; i < jsonAllDayWorked.length; i++) {
				allDaysWorked.push(jsonAllDayWorked[i]['date']);
			}

			loadCalendar(allDaysWorked);
		}
	};
	httpRequest.open('GET', `../config/recupAllDayWorked.php`, true);
	httpRequest.send();
}

function hoverDeleteLineExercise() {
	var lineExercise = document.querySelectorAll('.line_exercise');
	for (let i = 0; i < lineExercise.length; i++) {
		lineExercise[i].addEventListener('mouseover', function() {
			// alert("ok");
			lineExercise[i].lastChild.onclick = function(e) {
				var recupId = lineExercise[i].lastChild.classList[1]; // Recupere la deuxieme class, la ou il y a l'id
				recupId = recupId.replace('delete_logoid', ''); // recupere une class sous la forme idXXXX, sous la meme forme que la classe de .line_exercise
				deleteAllDiv(e.target.parentElement.parentElement, 'id' + recupId);
				var httpRequest = getHttpRequest();

				httpRequest.onreadystatechange = function() {
					if (httpRequest.readyState === 4) {
						if (httpRequest.status === 200) {
							var result = JSON.parse(httpRequest.response);
						} else {
							alert('impossible de contacterle serveur');
						}
					}
				};

				httpRequest.open('POST', '../config/deleteLineExercise.php', true);
				var data = new FormData();
				data.append('classId', recupId);
				httpRequest.send(data);
			};
		});
		// lineExercise[i].addEventListener('mouseout', function() {
		// 	lineExercise[i].lastChild.style.opacity = '0%'; //lastChild cible le dernier element, le button
		// });
	}
}

function refrechAllExercise(jsonObj) {
	if (jsonAllSessionDay.length == 0) {
		var emptySessionDiv = document.createElement('div');
		emptySessionDiv.classList.add('empty_session_div');
		allContain.insertBefore(emptySessionDiv, dayRecap); // Ajout de l'exercise en fonction dans l'id de son muscle

		var emptySessionText = document.createElement('p');
		emptySessionText.classList.add('empty_session_text');
		emptySessionText.innerHTML = "Vous n'avez pas entre de <span class='red'>programme</span> aujourd'hui";
		emptySessionDiv.appendChild(emptySessionText);
	} else {
		addHTMLTitleMuscle(jsonObj, 'all_for_muscle_solo', dayRecap);
		addHTMLTitleExercise(jsonObj);
		hoverDeleteLineExercise(); // permet de faire un event listener quand les elements sont charge, avant cela ne marche pas
	}
}

function allMusclesSelectInput(allMusclesJson) {
	allMusclesJson.forEach((line) => {
		var lineExercise = document.createElement('option');
		lineExercise.setAttribute('value', line['muscle']);
		lineExercise.innerHTML = line['muscle'].replaceAll('_', ' ');
		addMuscle.insertAdjacentElement('beforeend', lineExercise);
	});
}

function allExercisesSelectInput(allExercisesJson) {
	allExercisesJson.forEach((line) => {
		var nameUnbreakableMuscles = line['muscle'].replaceAll(' ', '_'); //Permet d'avoir un nom lisible
		var nameUnbreakableExercise = line['exercise'].replaceAll(' ', '_'); //Permet d'avoir un nom lisible
		if (nameUnbreakableMuscles == addMuscle.value) {
			var lineExercise = document.createElement('option');
			lineExercise.classList.add('select_exercise');
			lineExercise.setAttribute('value', nameUnbreakableExercise);
			lineExercise.innerHTML = line['exercise'].replaceAll('_', ' ');
			addExercise.insertAdjacentElement('beforeend', lineExercise);
		}
	});
}

function fetchJsonObj() {
	// Retourne en GET et choisi la fonction a executer
	httpRequest.onreadystatechange = () => {
		if (httpRequest.readyState == 4) {
			jsonAllSessionDay = JSON.parse(httpRequest.response);
			jsonAllSessionDay = jsonAllSessionDay.reverse();

			refrechAllExercise(jsonAllSessionDay); // Appel le refreche avec se qui est trouver en reponse fetch
			fetchAllDayWorked();
		}
	};
	httpRequest.open('GET', `../config/fetchExercise.php?id=${idUser.value}`, true);
	httpRequest.send();
}

function fetchJsonObjAllMuscles() {
	// Prends tout les muscles dans la base de donne pour les affiché dans l'input select
	httpRequest.onreadystatechange = () => {
		if (httpRequest.readyState == 4) {
			var jsonAllMuscles = JSON.parse(httpRequest.response);
			allMusclesSelectInput(jsonAllMuscles);
		}
	};
	httpRequest.open('GET', `../config/fetchAllMuscles.php`, true);
	httpRequest.send();
}

function fetchJsonObjAllExercises() {
	// Prends tout les muscles dans la base de donne pour les affiché dans l'input select
	httpRequest.onreadystatechange = () => {
		if (httpRequest.readyState == 4) {
			var result = JSON.parse(httpRequest.response);
			allExercisesSelectInput(result);
		}
	};
	httpRequest.open('GET', `../config/fetchAllExercises.php`, true);
	httpRequest.send();
}

fetchJsonObj();

addMuscle.addEventListener('change', function() {
	// addExercise.innerHTML = "" // Il faut effacer ce qu'il y a avant
	deleteAllDiv(addExercise, 'select_exercise'); //Supprime toute les option car ils ont la classe select_exercises
	fetchJsonObjAllExercises(); // Affiche les exercises en fonction du muscle selectionné
});

buttonSumbitDay.addEventListener('click', function(e) {
	//Ajoute un muscle directement au clique
	e.preventDefault();
	var httpRequest = getHttpRequest();

	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState === 4) {
			if (httpRequest.status === 200) {
				var result = JSON.parse(httpRequest.response);

				if (document.querySelector('.empty_session_div') != null) {
					// Si la div "Aucun programme rentré existe", on doit l'enlever car on viens d'ajouter quelque chose
					deleteAllDiv(allContain, 'empty_session_div');
				}

				if (document.getElementById(`muscle_${result['muscle']}`) == null) {
					// Si le muscle existe
					addOneHTMLTitleMuscle(result);
					addOneHTMLTitleExercice(result);
					//addOneHTMLLineExercise(result)
				}
				if (
					document.getElementById(`muscle_${result['muscle']}`) != null &&
					document.getElementById(`exercise_${result['muscle']}_${result['nom_exercise']}`) == null
				) {
					addOneHTMLTitleExercice(result);
				}

				if (
					document.getElementById(`muscle_${result['muscle']}`) != null &&
					document.getElementById(`exercise_${result['muscle']}_${result['nom_exercise']}`) != null
				) {
					//Si le muscle et exercise existe
					addOneHTMLLineExercise(result);
				}
			} else {
				alert('impossible de contacterle serveur');
			}
		}
	};

	httpRequest.open('POST', '../config/addInBdd.php', true);
	var data = new FormData();

	if (e.target.id === 'submit_day_session') {
		data.append('addMuscle', addMuscle.value);
		data.append('addExercise', addExercise.value);
		data.append('addWeight', addWeight.value);
		data.append('addRepetition', addRepetition.value);
		data.append('id', idUser.value);
	}

	httpRequest.send(data);
});

// showMore.addEventListener('click', function(e) {
// 	document.querySelector('.all_series').classList.toggle('active');
// });

