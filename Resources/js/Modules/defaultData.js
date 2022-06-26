
export function NewNode(parentId, nodeComponent, data)
{
    this.id            = null;
    this.parentId      = parentId;
    this.nodeComponent = nodeComponent;
    this.data          = data;
    this.valid         = false;
    this.active        = false;
    this.hasChildren   = false;
}

export function DefaultIncomingLineData()
{
    this.headerText = 'Start Here';
    this.lineList   = [''];
}

export function DefaultScheduleData()
{
    this.headerText = 'Business Hours';
    this.schedule  = [
            {
                start_time: '08:00',
                stop_time : '17:00',
                days      : ['mon', 'tue', 'wed', 'thu', 'fri'],
            }
        ];
}

export function DefaultGreetingData()
{
    this.headerText       = '24/7 Greeting';
    this.greeting         = '';
    this.availableOptions = [0,1,2,3,4,5,6,7,8,9,11];
}

export function DefaultOptionData()
{
    this.headerText       = '';
    this.num              = '?';
    this.verbage          = 'Press';
    this.whatHappens      = null;
    this.targetExtension  = [];
    this.availableOptions = [];
}
