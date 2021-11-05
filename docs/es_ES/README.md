# Escenario Acondicionador plugin para Jeedom

<p align="center">
  <img width="100" src="/plugin_info/scenario_conditionner_icon.png">
</p>

Este plugin permite habilitar o deshabilitar escenarios basados en la evaluación de una condición.

La condición se evalúa como entrada (verdadero) o salida (falso) y las acciones son configurables en ambos casos.


# |Configuración
  
  1. activar el plugin
  
  2. Configuraciones: sin configuración
  
  3. crear un primer equipo
 
  
 # Equipamiento
 <p align="center">
  <img width="100%" src="/plugin_info/img/equipement.PNG">
</p>

 

 ### Ajustes generales      
 
 * __Nombre del equipo__ 
 * __Objeto padre__ 
 * _Categoría__ 
 * 
 Como con todos los equipos convencionales
 
 ### Resumen de escenarios y acciones
 A continuación se muestra un resumen de los escenarios configurados en la pestaña "Acondicionador de escenarios", así como las acciones establecidas dentro y fuera de la condición.
 
 
 ### Condición  
  * __Condición a evaluar__ : Condición que Iedom evaluará (ver probador de expresiones) para definir si entramos en la condición (==true) o salimos de ella (==false). El botón de la derecha permite seleccionar los comandos de información a evaluar (comportamiento similar al de los escenarios para los bloques **si**)
  El botón de la derecha permite seleccionar los comandos de información que se van a evaluar (de forma similar al comportamiento de los escenarios para los bloques **Si**) 
  * __Test__ : Botón para abrir el comprobador de expresiones con la condición pre-rellenada para la prueba.
 
 # Comandos
  
 Con la instalación se crean cuatro comandos: 
* __Status__ : Da el estado verdadero/falso que está vinculado a la evaluación de la condición o a un valor forzado por los comandos force in o force out
* __Force Verification__ : forzar la evaluación de la condición
* __Forzar la entrada__ : forzar las acciones de entrada, y establecer el estado en verdadero
* __Forzar la salida__ : forzar las acciones de salida, y establecer el estado en falso


 # Escenarios
 <p align="center">
  <img width="100%" src="/plugin_info/img/scenario.PNG">
</p>

Aquí se añaden los escenarios que se quieren gestionar y se definen las acciones de entrada y salida de las condiciones

* __Añadir un escenario__ : añadir un comando "escenario"
* Haga clic en el icono situado junto al campo de escenario para abrir el selector de escenarios;
* Elegir las acciones de entrada y salida entre :
  * __Activar__ : activar el escenario
  * __Desactivar__ : desactivar el escenario
  * __No hacer nada__ : no actuar ante el cambio de condición (entrada o salida)
 
 
