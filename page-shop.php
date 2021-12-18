<?php

get_header(); 
/* Start the Loop */

?>

<style>
	/* RYK ALLE STYLES OVER I CUSTOM.CSS */
main {
  display: grid;
  grid-template-columns: 1fr minmax(0, 1000px) 1fr;
}
main section {
  grid-column: 2/3;
}

video {
  display: block;
  width: 100%;
  height: auto;
  padding: 0;
  border: solid 1px black;
}

#indledning{
display: grid;
justify-content: center;
padding-bottom: 2.5rem;
}

#indledning h1, #indledning p{
	text-align: center;
}

/* style på grid-produktoversigt i mobile */
#filtrerings_knapper {
      display: grid;
      grid-template-columns: 1fr 1fr;
	  margin-bottom: 1.5rem;
    }
#filter_knapper, #alle_knap{
	background-color: #003BFF;
	color: white;
	border: solid 0.5px black;
}

#filter_knapper:hover, #alle_knap:hover, .valgt{
	background-color: #002498;
	text-decoration-line: underline;
	
}

#produktoversigt{
	display: grid;
	grid-template-columns: 1fr 1fr;
	}
	

#alle_knap {
      grid-column: 1/3;
    }

/* Style på produkt-boks i oversigt */
.produkt{
	cursor: pointer;
}

.produkt_information {
  position: absolute;
  padding: 0.5rem;
  width: 10.5rem;
}
.produkt_navn,
.produkt_pris {
  color: black;
}
@media (min-width: 700px) {
	#produktoversigt{
		grid-template-columns: 1fr 1fr 1fr;
		}	

	.produkt_information {
  		width: 15rem;
	}
	
	#indledning{
		padding-bottom: 5rem;
	}
	#filtrerings_knapper{
		grid-template-columns: 1fr 1fr 1fr 1fr;
		margin-bottom: 2rem;
		border: solid 0.5px black;
	}	
	#alle_knap {
      grid-column: span 4;
    }
}
@media (min-width: 1000px) {
	#produktoversigt{
		grid-template-columns: repeat(4, 1fr);
		}
	.produkt_information {
  		width: 15rem;
}
		
	#filtrerings_knapper{
		grid-template-columns: 1fr 1fr 1fr 1fr;
		margin-bottom: 2rem;
		border: solid 0.5px black;
	}	
	#alle_knap {
      grid-column: span 4;
    }
}

</style>

<main>
	<section>
<article id="indledning">
	<h1>Shop Do Lah</h1>
	<p>Lækre og økologiske sæbebarer som kan bruges af hele husstanden. Alle sæbebarer fra Do Lah kan bruges på både krop og hænder, og passer til alle hudtyper. </p>
</article>
<nav id=filtrerings_knapper>
	<button id="alle_knap" class="filter_knapper" class="filter" class="valgt" data-produkt="alle">Alle</button>
</nav>

<section id="produktoversigt"></section>
<template id="enkelt_produkt">
	<figure class="produkt">
		<div class="produkt_information">
            <p class="produkt_navn"></p>
            <p class="produkt_pris"></p>
        </div>
		<video muted class="produktbillede" src="" alt="">
	</figure>
</template>
</section>
</main>

<script>
// Her starter JS. console.log for at tjekke om der er forbindelse
// console.log("hip hurra");

// Oprettelse af variabler
let produkter;
let produktType;
let filterProdukt = "alle";

const url = "https://lineberner.com/kea/2_semester/dolah/wp-json/wp/v2/soap/?per_page=100";
const typeUrl = "https://lineberner.com/kea/2_semester/dolah/wp-json/wp/v2/product_type";

// Oprettelse af function 'getJson' og definer hvordanm rest API'en hentes ind, og start function 'visProdukter'
async function getJson(){
	const response = await fetch(url);
	const typeData = await fetch(typeUrl);

	produkter = await response.json();
	produktType = await typeData.json();
	// console.log(produktType);

	// Kald funktioner
	visProdukter();
	opretKnapper();
}

// Her oprettes filtreringsknapperne ud fra dynamisk indhold. Her ud fra kategorien "produkttype"
function opretKnapper(){
	produktType.forEach(type=>{
		document.querySelector("#filtrerings_knapper").innerHTML += `<button id="filter_knapper" class="filter" data-produkt="${type.id}">${type.name}</button>`
	})
	// Kald funktion 
	addEventListenersToButtons(); 
}
// Her gøres alle knapperne klikbarer
function addEventListenersToButtons(){
	document.querySelectorAll("#filtrerings_knapper button").forEach(knap =>{
		knap.addEventListener("click", filtrering);
	})
};

function filtrering(){
	filterProdukt = this.dataset.produkt;
	//fjern .valgt fra alle
	document.querySelectorAll("#filtrerings_knapper .filter").forEach(knap =>{
	knap.classList.remove("valgt");
	});
	//tilføj .valgt til den aktive knap
	this.classList.add("valgt");
	// Kald funktion
	visProdukter();
	startVideoer();
}

// Oprettelse af function 'start' (som starter så snart siden er loaded)
document.addEventListener("DOMContentLoaded", start);

// Sæt function 'start' igang og vis json/rest API indhold
function start(){
	// Kald funktion
	getJson()
}

// Oprettelse af function 'visProdukter'
function visProdukter(){
	// Oprettelse af variabler
	const skabelon = document.querySelector("template");
	const liste = document.querySelector("#produktoversigt");
	
	// Tøm visningscontaineren (liste) før hver visning, altså hver gang der bliver skiftet kategori
	liste.innerHTML = "";

	// Definer hvilket indhold der skal vises i template. forEach = for hvert produkt vises navn, pris og billede
	produkter.forEach(produkt =>{
		if ( filterProdukt == "alle" || produkt.product_type.includes(parseInt(filterProdukt))){
		const klon = skabelon.cloneNode(true).content;
		klon.querySelector(".produkt_navn").textContent = produkt.navn;
		klon.querySelector(".produkt_pris").textContent = produkt.pris;
		klon.querySelector("video").src = produkt.video.guid;
		klon.querySelector("video").alt = produkt.navn;

		// Start og slut produktvideo ved hover på elementet
		klon.querySelector("video").addEventListener("mouseover",(e)=>e.target.play());
		klon.querySelector("video").addEventListener("mouseout",(e)=>e.target.pause());

		// Gør produktet klikbart og send bruger videre til det enkelte produkts oversigt
		klon.querySelector("figure").addEventListener("click", ()=>{location.href = produkt.link});

		// Tilføj elementerne (klon) til #produktoversigt (liste)
		liste.appendChild(klon);
		}
	})
}

</script>

<?php
get_footer();
