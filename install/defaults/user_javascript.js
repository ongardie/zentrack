
/**
 * Javascript functions may be placed here which will manipulate, validate
 * or otherwise affect client-side data.  Almost any form field on the ticket
 * create or edit screens can be edited by placing a properly named function
 * here.
 *
 * To find out what to name your function, view the source of the page you
 * wish to affect, find the desired field, and gather the following information:
 * the value of the <b>form's (&lt;form&gt;) name='...'</b> element which contains the field, 
 * and the value of the <b>form field's name='...' attribute.
 *
 * The format of the function name is: "usr_fxn_form_field" where form represents the name of
 * the form and field represents the name of the field.  The field name is case sensitive!
 *
 * All function names must begin with "usr_fxn_".  The parameters passed to the function will be
 * a reference to the DOM object for this field (document.theForm.theField), and a string
 * representing the event which has occurred.
 *
 * The function should handle any of the following events (the event type will be passed as
 * a string):
 * <ul>
 *  <li><b>onfocus</b> - focus is entering the field 
 *  <li><b>onblur</b> - focus is leaving the field
 *  <li><b>onchange</b> - the value of the field has changed
 *  <li><b>onsubmit</b> - the form was submitted (do any validation here)
 * </ul>
 *
 * Example:
 * <code>
 *   // this is an example function which validates a form field's value
 *   // and takes appropriate action if it's no good.  In our example, the
 *   // form is called randomForm and the field is called randomField
 *   function usr_fxn_randomForm_randomField( fieldObject, event ) {
 * 
 *      // in our example, we are simply going to deal with onblur and onsubmit events,
 *      // because that's the only time we will need to validate
 *      if( event == 'onblur' || event == 'onsubmit' ) {
 * 
 *        // we will validate the form field's value, and focus
 *        // back to the cell if it isn't valid.  We will return
 *        // true/false in case this is the onsubmit call, so that
 *        // the form will not send until this field value is valid
 *        if( formObject.value == "" ) {
 *          alert("The form field " + fieldObject.name + " is required!");
 *          fieldObject.focus();
 *          return false;
 *        }
 *        
 *        // our test passed, so return true (so that onsubmit works)
 *        return true;
 *      }
 *   }
 * </code>
 *
 * <b>The return value of the function will be ignored for all values except the onsubmit, where
 * it is mandatory!</b>
 *
 * See the documentation on user defined javascript for more information.
 */
