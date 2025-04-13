
window.revelar = ScrollReveal({reset:true})

// TOPO DO SITE

revelar.reveal('.pro' ,
{
  duration: 2000,
  distance: '90px',
}
)

revelar.reveal('.start' ,
  {
    duration: 0,
    distance: '0',
    delay: 0,
    origin: 'right'
})

revelar.reveal('.empresa' ,
{
  duration: 2000,
  distance: '90px',
  delay: 1500,
  origin: 'left'
})