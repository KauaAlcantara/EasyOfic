
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
    duration: 2000,
    distance: '90px',
    delay: 1000,
    origin: 'right'
})

revelar.reveal('.empresa' ,
{
  duration: 2000,
  distance: '90px',
  delay: 1500,
  origin: 'left'
})