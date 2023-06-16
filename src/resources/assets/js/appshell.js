document.addEventListener('DOMContentLoaded', function () {
  document
    .querySelectorAll('input[name="_method"][type="hidden"][value="DELETE"]')
    .forEach(deleter => {
      deleteForm = deleter.closest('form')
      if (deleteForm) {
        deleteForm.onsubmit = event => {
          let confirmText = event.target.dataset.confirmationText ? event.target.dataset.confirmationText : 'Are you sure you want to delete this item?'

          if (!confirm(confirmText)) {
            event.preventDefault();
          }
        }
      }
    })
})
//
// function MultiselectDropdown(options){
//     var config={
//         search:true,
//         height: '15rem',
//         style: { width: 'auto' },
//         placeholder:'select',
//         txtSelected:'selected',
//         txtAll:'All',
//         ...options
//     };
//     function newEl(tag,attrs){
//         var e=document.createElement(tag);
//         if(attrs!==undefined) Object.keys(attrs).forEach(k=>{
//             if(k==='class') { Array.isArray(attrs[k]) ? attrs[k].forEach(o=>o!==''?e.classList.add(o):0) : (attrs[k]!==''?e.classList.add(attrs[k]):0)}
//             else if(k==='style'){
//                 Object.keys(attrs[k]).forEach(ks=>{
//                     e.style[ks]=attrs[k][ks];
//                 });
//             }
//             else if(k==='text'){attrs[k]===''?e.innerHTML='&nbsp;':e.innerText=attrs[k]}
//             else e[k]=attrs[k];
//         });
//         return e;
//     }
//
//
//     document.querySelectorAll("select[multiple]").forEach((el,k)=>{
//
//         var div=newEl('div',{class:['multiselect-dropdown', 'form-control', 'form-control-sm'],style:{width:config.style?.width??(el.clientWidth + 35)+'px',padding:config.style?.padding??'',"min-width":(el.clientWidth + 35)+'px'}});
//         el.style.display='none';
//         el.parentNode.insertBefore(div,el.nextSibling);
//         var listWrap=newEl('div',{class:'multiselect-dropdown-list-wrapper'});
//         var list=newEl('div',{class:'multiselect-dropdown-list',style:{height:config.height}});
//         var search=newEl('input',{class:['multiselect-dropdown-search'].concat([config.searchInput?.class??'form-control']),style:{width:'100%',display:el.attributes['multiselect-search']?.value==='true'?'block':'none'},placeholder:'search'});
//         listWrap.appendChild(search);
//         div.appendChild(listWrap);
//         listWrap.appendChild(list);
//
//         el.loadOptions=()=>{
//             list.innerHTML='';
//
//             if(el.attributes['multiselect-select-all']?.value == 'true'){
//                 var op=newEl('div',{class:'multiselect-dropdown-all-selector'})
//                 var ic=newEl('input',{type:'checkbox'});
//                 op.appendChild(ic);
//                 op.appendChild(newEl('label',{text:config.txtAll}));
//
//                 op.addEventListener('click',()=>{
//                     op.classList.toggle('checked');
//                     op.querySelector("input").checked=!op.querySelector("input").checked;
//
//                     var ch=op.querySelector("input").checked;
//                     list.querySelectorAll("input").forEach(i=>i.checked=ch);
//                     Array.from(el.options).map(x=>x.selected=ch);
//
//                     el.dispatchEvent(new Event('change'));
//                 });
//                 ic.addEventListener('click',(ev)=>{
//                     ic.checked=!ic.checked;
//                 });
//
//                 list.appendChild(op);
//             }
//
//             Array.from(el.options).map(o=>{
//                 var op=newEl('div',{class:o.selected?'checked':'',optEl:o})
//                 var ic=newEl('input',{type:'checkbox',checked:o.selected});
//                 op.appendChild(ic);
//                 op.appendChild(newEl('label',{text:o.text}));
//
//                 op.addEventListener('click',()=>{
//                     op.classList.toggle('checked');
//                     op.querySelector("input").checked=!op.querySelector("input").checked;
//                     op.optEl.selected=!!!op.optEl.selected;
//                     el.dispatchEvent(new Event('change'));
//                 });
//                 ic.addEventListener('click',(ev)=>{
//                     ic.checked=!ic.checked;
//                 });
//
//                 list.appendChild(op);
//             });
//             div.listEl=listWrap;
//
//             div.refresh=()=>{
//                 div.querySelectorAll('span.optext, span.placeholder').forEach(t=>div.removeChild(t));
//                 var sels=Array.from(el.selectedOptions);
//                 if(sels.length>(el.attributes['multiselect-max-items']?.value??5)){
//                     div.appendChild(newEl('span',{class:['optext','maxselected'],text:sels.length+' '+config.txtSelected}));
//                 }
//                 else{
//                     sels.map(x=>{
//                         var c=newEl('span',{class:'optext',text:x.text});
//                         div.appendChild(c);
//                     });
//                 }
//                 if(0 === el.selectedOptions.length) div.appendChild(newEl('span',{class:'placeholder',text:el.attributes['placeholder']?.value??config.placeholder}));
//             };
//             div.refresh();
//         }
//         el.loadOptions();
//
//         search.addEventListener('input',()=>{
//             list.querySelectorAll("div").forEach(d=>{
//                 var txt=d.querySelector("label").innerText.toUpperCase();
//                 d.style.display=txt.includes(search.value.toUpperCase())?'block':'none';
//             });
//         });
//
//         div.addEventListener('click',()=>{
//             div.listEl.style.display='block';
//             search.focus();
//             search.select();
//         });
//
//         document.addEventListener('click', function(event) {
//             if (!div.contains(event.target)) {
//                 listWrap.style.display='none';
//                 div.refresh();
//             }
//         });
//     });
// }
//
// window.addEventListener('load',()=>{
//     MultiselectDropdown(window.MultiselectDropdownOptions);
// });
