---
title: myproject
menu: Home
onpage_menu: true
body_class: index
header_class: alt
content:
    items: @self.modular
    order:
        by: default
        dir: asc
        custom:
            - _banner
            - _icons
            - _header
            - _features
            - _portfolio
            - _contact
process:
  twig: true
cache_enable: false

form:
    name: contacto
    action : /
    fields:
    -
        name: nombre
        label: Nombre
        placeholder: 'Ingrese ambos nombres'
        autofocus: 'on'
        autocomplete: 'on'
        type: text
        
    -
        name: apellido
        label: Apellido
        type: text
        
    -
        name: correo
        label: Correo Electrónico
        type: email
        validate:
            required : true
        
    - 
      name: telefono
      label: Telefono
      placeholder: 212-222-2222
      type: text
    
    buttons:
    -
        type : submit
        value : Enviar

    process:
        - whm :
---


