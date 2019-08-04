Ticket System Net Tech International
====================================

**Desarrolado por:** ***Yansell Rivas Diaz***

Requerimientos para la instalación:
==================================
    
  * Instalacion de un servidor con PHP.
  * Instalación de composer en tu ordenador.
  * Instalación de GIT (Solo si va a clonar el repositorio)
  [link aqui...](https://github.com/yansellrivasdiaz/ticket_system). 
---------------------------------------------------------------
Instalación de la Aplicación:
============================
  
   * Ir mediante la terminar de linux o CMD windows a dondr 
   quieras instalar la aplicación web.
   * Clonar el [Repositorio](https://github.com/yansellrivasdiaz/ticket_system) desde github o descargar
   a tu ordenador y desconprimir en la carpeta donde deseas acceder 
   en modo local.
   * Una vez descargado o clonado debes ejecutar los siguientes comandos:
     
     * **Composer install**
     * **Editar archivo ***app/config/parameters.yml*** 
     y cambiar los parametros de conexion a la base de datos 
     parametros**
     * **php bin/console doctrine:database:create.**
     * **php bin/console doctrine:schema:update --force**
     * **php bin/console doctrine:fixtures:load**
     
   * Ahora puedes haceder a la ruta del proyecto ruta:
    127.0.0.1(o Nombre dle servidor)/ticket_system.
    
**Nota:** Los datos de accesos al sistema son los siguientes:
    
    * username: admin (Email: admin@admin.com) 
    * Password: admin    

Felicidades si todo salió bien ya puedes empezar a utilizar la App
Ticket System.
---------------------------------------------------------------
**Documentación:**
==================

**1-  Página de login.**

![Pantalla login](./web/app-images-docs/login_form.PNG)
 
Puede loguearse en la aplicacion mediante nombre de usuario o email, y la contraseña, en caso del usuario por defecto de la aplicación al momento de instalarlo es: ***username:admin*** & ***password:admin*** 

**2-  Pantalla de inicio (Tickets).**

![Pantalla login](./web/app-images-docs/ticket_page.PNG)

Esta pantalla mostrará todos los ticket que se encuentran activos y en la misma podrá visualizar ticket, Agregar notas, los tickets creado por el usuario logueado podrán ser editados, borrardos y cerrados por el mismo.

**3-  Pantalla de visualizar (Ticket).**

![Pantalla login](./web/app-images-docs/ticket_view_page.PNG)

En esta pantalla podrá visualizar ticket y ver la información detallada de los mismos, tanto los ***time entries*** como los ***empleados*** a los que fue asignado el mismo, el usuario logueado podrá borrar las notas si son creadas por el mismo, tiene acceso a borrar el ticket y editarlo.

**Nota:** Los usuarios en esta pantalla solos podrán visualizar los tickets creados por ellos mismos y los ticket a los que son asignados para solucionarlos.

* **3.1-  Pantalla de visualizar (Ticket/Employee(s)).**

![Pantalla login](./web/app-images-docs/ticket_view_page_employee.PNG)

**4-  Pantalla para agregar (Ticket).**

![Pantalla login](./web/app-images-docs/ticket_form.PNG)

En esta pantalla podrá crear nuevos ticket y asignarlos a multiples empleados, las misma tiene valización de datos tanto back-end como front-end.

**5-  Pantalla time entries form (Ticket).**

![Pantalla login](./web/app-images-docs/time_entries_form.PNG)

En esta pantalla podrá agregar ticket a los ticket, tanto el usuario que lo creó como el que está trabajando el ticket, las notas podrán ser aliminadas y editadas por el creador de la misma.

**6-  Pantalla de listado empleados(Employees List).**

![Pantalla login](./web/app-images-docs/employee_page.PNG)

En esta pantalla podrán visualizarse los empleados creados asi como puedes activar o desactivar los mismos, desde esta pantalla se accede al formulario de crearción de empleados.

**6-  Pantalla de registro empleados(Employees Form).**

![Pantalla login](./web/app-images-docs/employee_form.PNG)

En esta pantalla se pueden registrar los empleados, todos los campos de la misma son requeridos.

**7-  Pantalla de vista empleado(Employees View).**

![Pantalla login](./web/app-images-docs/employee_view_page_with_ticket_view.PNG)

En esta pantalla podrá tener una vista previa de un empleado, así como los tickets creados por el mismo y el usuario logueado podrá eliminar los tickets creado por él y editarlos desde esta pantalla.

**8-  Pantalla de reportes(Ticket Reports).**

![Pantalla login](./web/app-images-docs/report_page.PNG)

En esta pantalla podrá generar reportes de tickets donde se presenta un detalla de los mismos del estado y tiempos de relución de los mismos.

***@copyright 2019 Ing. Yansell Rivas***
