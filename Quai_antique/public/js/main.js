$(function() {
    // Owl Carousel
    var owl = $(".owl-carousel");
    owl.owlCarousel({
      items: 1,
      margin: 10,
      loop: true,
      nav: true,
      autoplay:true,
      autoplayTimeout:3000,
      autoplayHoverPause:true,
      
    });
  });
  

  /* ============================================================
 * bootstrap-portfilter.js for Bootstrap v2.3.1
 * https://github.com/geedmo/portfilter
 * ============================================================*/
!function(d)
{
  var c="portfilter";
  var b=function(e)
  {
    this.$element=d(e);
    this.stuff=d("[data-tag]");  
    this.target=this.$element.data("target")||""
  };

  b.prototype.filter=function(g){
    var e=[],f=this.target;
    this.stuff.fadeOut("fast").promise().done(function()
    {
      d(this).each(
        function()
        {
          if(d(this).data("tag")==f||f=="all")
          {
            e.push(this)
          }
        }
      );
      d(e).show()})};var a=d.fn[c];
      d.fn[c]=function(e){
        return this.each(function()
        {  var g=d(this),f=g.data(c);
          if(!f)
          {
            g.data(c,(f=new b(this)))
          }
          if(e=="filter")
          {
            f.filter()
          }
        })
      };
    
    d.fn[c].defaults={};
    d.fn[c].Constructor=b;d.fn[c].noConflict=function(){d.fn[c]=a;
    return this};d(document).on("click.portfilter.data-api","[data-toggle^=portfilter]",function(f){d(this).portfilter("filter")})
}(window.jQuery);


/* ============================================================
 * Gérer les CollectionTypes dans le formulaire InfoTable (Heure Midi, Heure Soir)
 * ============================================================*/


window.onload =  () => {
  const newItem = (e) => {
    const collectionHolder = document.querySelector(e.currentTarget.dataset.collection);
  
    const item = document.createElement("div");
    item.classList.add("col-4");
    
    item.innerHTML += collectionHolder
    .dataset
    .prototype
    .replace(
        /__name__/g,
        collectionHolder.dataset.index
    );
  
    item.querySelector(".btn-remove").addEventListener("click", () => item.remove());
  
    collectionHolder.appendChild(item);
  
    collectionHolder.dataset.index++;
  
  }
  
  document.querySelectorAll('.btn-remove').forEach(btn => btn.addEventListener('click', (e) => e.currentTarget.closest(".col-4").remove()));
  
  document.querySelectorAll('.btn-new').forEach(btn => btn.addEventListener('click', newItem));
  
 
}

 /* ============================================================
   * Gérer les nombre de convives dans le formulaire Reservation
   * ============================================================*/
  
 window.onload = () =>
 {
     // On va chercher le champ qui contient le jour
     let nombre = document.querySelector('#form_nbreConvive');
     let error = document.getElementById('error')
   
     const handleChange = (event) => {
       
       let data = {
        nombre: event.target.value
       };

       fetch('/traitement')
        .then(response => response.json())
        .then(result => {
          let place = result[1].placeNumber;
          let placeDB = ((result[0][1] === null) ? 0 : parseInt(result[0][1]) );
          let placeRestante = place - placeDB;
          console.log(placeRestante);
          
          if((placeRestante < parseInt(data)) && (placeRestante === 0))
          {
            error.innerHTML = "Toutes les places sont malheureusement occupés !";
            error.style.color = "red";
          } else if ( (placeRestante < parseInt(data.nombre)) && (placeRestante > 0))
          {
            error.innerHTML = 'Maleheuresement nous avons '+placeRestante+' restantes';
            error.style.color = "red";
          } else if ( parseInt(data.nombre) === 0)
          {
            error.innerHTML = 'Veillez saisir le nombre de convive !';
            error.style.color = "red";
          }else 
          {
            error.innerHTML= "Le nombre de place validé !";
            error.style.color = "green";
          }
         
        })
        .catch(error => {
          console.log(error);
        })
     }
     
   
     nombre.addEventListener("change", handleChange);


     // Traitement des données du formulaire Reservation
     
     const form = document.querySelector('form_js');

      const handleSubmit = (event) => {
      event.preventDefault();
       
      

      const formData = new FormData(form);

      const data = formData.get('form[nbreConvive]');
       
       fetch('/traitement')
        .then(response => response.json())
        .then(result => {
          let place = result[1].placeNumber;
          let placeDB = ((result[0][1] === null) ? 0 : parseInt(result[0][1]) );
          let placeRestante = place - placeDB;
          
          if((placeRestante < parseInt(data)) && (placeRestante === 0))
          {
            error.innerHTML = "Toutes les places sont malheureusement occupés !";
            error.style.color = "red";
          } else if ( (placeRestante < parseInt(data)) && (placeRestante > 0))
          {
            error.innerHTML = 'Maleheuresement nous avons '+placeRestante+' restantes';
            error.style.color = "red";
          } else if ( parseInt(data) === 0)
          {
            error.innerHTML = 'Veillez saisir le nombre de convive !';
            error.style.color = "red";
          }else 
          {
            fetch("/reserver", {
              method: 'POST',
              body: formData,
            })
            .then(response => response.text())
            .then(response => {

                document.querySelector('html').innerHTML = response; 

            })
            .catch(error => {
              // Affichage du message d'erreur
              // ...
            });
          }
         
        })
        .catch(error => {
          console.log(error);
        })
     }
     
    
    form.addEventListener('submit', handleSubmit)
 } 
 

  
  /* ============================================================
   * Gérer les nombre de convives dans le formulaire Reservation
   * ============================================================*/
 

/* ===================================
 *    Gérer le format de la date
 * ===================================*/










