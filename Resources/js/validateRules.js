/**
 * Extra Vee-Validate rules for the AutoAttendantBuilderModule
 */
import { extend } from 'vee-validate';

/**
 * Time Compare rule for Vee-Validate
 */
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

/**
 * Compare the list of phone numbers to make sure that they are unique
 */
extend('unique-phone-number', {
    params: ['numberList'],
    validate(newNumber, { numberList }) {
        let hasArr = [];
        for(let num of numberList)
        {
            if(num === newNumber)
            {
                hasArr.push(num);
            }
        }

        if(hasArr.length > 1)
        {
            return false;
        }

        return true;
    },
    message: 'You have already used this number.  Each entry must be unique',
});

/**
 * Compare list of used one key options to make sure they are unique
 */
extend('unique-one-key', {
    params: ['optList'],
    validate(dialOption, { optList }) {

        console.log(optList);

        let hasArr = [];
        for(let opt in optList)
        {
            console.log('opt num - '+opt.optNum);
            if(opt.optNum == dialOption)
            {
                hasArr.push(opt.optNum);
            }
        }

        console.log('has array');
        console.log(hasArr);

        if(hasArr.length > 1)
        {
            return false;
        }

        return true;
    },
    message: 'This option can only be used once',
});
