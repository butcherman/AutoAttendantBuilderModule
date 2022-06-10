import upperFirst   from 'lodash/upperFirst';

export let whatHappensDropdown = [
    '',
    'Play Greeting',
    'Take Message',
    'Ring Phone(s)',
    'Staff Directory',
    'Repeat',
    'Hang Up',
];

export function findDialOptions(greeting)
{
    const regex  = /(press|dial) \d/gmi;
    let foundOpt = greeting.match(regex);

    //  The default option that is in every AA Tree is time out
    let dialOptions = [
        {
            optNum: 11,
            verbage: 'Time Out',
            targetExtension: [],
        }
    ];

    if(foundOpt != null)
    {
        foundOpt.forEach(opt => {
            let number = opt.match(/\d+/);
            let verbage = opt.match(/(press|dial)/gmi);

            dialOptions.push({
                optNum: Number(number[0]),
                verbage: upperFirst(verbage),
                targetExtension: [],
            });
        });
    }

    return dialOptions;
}
