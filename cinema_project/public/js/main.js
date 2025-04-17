document.addEventListener('DOMContentLoaded',()=>{
    // можно добавить динамику при нажатии на свободное место
    document.querySelectorAll('.seat.free input').forEach(cb=>{
      cb.addEventListener('change',e=>{
        e.target.parentNode.classList.toggle('selected', e.target.checked);
      });
    });
  });