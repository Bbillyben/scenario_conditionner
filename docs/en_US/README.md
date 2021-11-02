# Scenario Conditioner plugin for Jeedom

<p align="center">
  <img width="100" src="/plugin_info/scenario_conditioner_icon.png">
</p>

This plugin allows you to enable or disable scenarios based on the evaluation of a condition.

The condition is evaluated as input (true) or output (false) and the actions are configurable on both.


# |Configuration|
  
  1. activate the plugin
  
  2. Configurations : no configuration
  
  3. create a first equipment
 
  
 # |Equipment|
 <p align="center">
  <img width="100%" src="/plugin_info/img/equipment.PNG">
</p>

 

 ### General Settings      
 
 * __Equipment Name__ 
 * __Parent Object__ 
 * __Category__ 
 * 
 Like any classic equipment
 
 ### Summary of scenarios and actions
 Here is a summary of the scenarios configured in the "Scenario Conditioner" tab, as well as the actions set in and out of the condition.
 
 
 ### Condition  
  * __Condition to evaluate__ : Condition that Iedom will evaluate (see expression tester) to define if we enter the condition (==true) or exit it (==false). The button on the right allows to select info commands to evaluate (similar behavior to the one in the scenarios for the **if** blocks)
  * __Test__ : Button to open the expression tester with the pre-filled condition for testing.
 
 # Commands
  
 Four commands are created with the tool: 
* __Status__ : Gives the true/false status which is linked to either the evaluation of the condition or to a value forced by the force in or force out commands
* __Force Verification__ : force the evaluation of the condition
* force input__ : force the input actions, and set the status to true
* __Force Output__ : force output actions, and set status to false
