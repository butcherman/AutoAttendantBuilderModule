/**
 * Time Compare rule for Vee-Validate
 */
 import { extend } from 'vee-validate';

 extend('after-start', {
     params: ['startTime'],
     validate(endTime, { startTime }) {
         //  Extract Hours and Minutes from values
         var startParts = startTime.split(':');
         var endParts   = endTime.split(':');

         //  Compare hours
         if(endParts[0] > startParts[0])
         {
             return true;
         }
         //  If the hours match, compare the minutes
         else if(endParts[0] == startParts[0])
         {
             //  End minutes must be greater than the start minutes
             if(endParts[1] > startParts[1])
             {
                 return true;
             }
             else
             {
                 return false;
             }
         }

         return false;
     },
     message: 'The Stop Time must be after the Start Time',
 });
