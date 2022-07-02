import { defineStore } from 'pinia';

export const useFlowStore = defineStore('flow', {
    state: () => {
        return {
            idIndex   : 0,
            stepIndex : 0,
            nodes     : [],
            steps     : [],
        }
    },
    getters: {
        activeStep()
        {
            if(this.steps.length)
            {
                return this.steps[this.stepIndex];
            }

            return {};
        }
    },
    actions: {
        buildNode(parentId, nodeComponent, data)
        {
            let newNode = {
                id         : this.idIndex++,
                parentId,
                nodeComponent,
                data,
                valid      : false,
                active     : false,
                hasChildren: false,
            }

            this.nodes.push(newNode);
            this.notifyParent(parentId);

            return newNode;
        },
        validateAllnodes()
        {
            this.nodes.forEach(node => node.valid = true);
        },
        buildWizardStep(component, data, parentId)
        {
            let newStep = {
                nodeId  : null,
                nextStep: [],
                parentId,
                component,
                data,
            }

            this.steps.push(newStep);
        },
        notifyParent(parentId)
        {
            let parent = this.nodes.find(node => node.id === parentId);
            if(parent)
            {
                parent.hasChildren = true;
            }
        },
        updateParent(parentId)
        {
            let hasChildren = this.nodes.includes((item) => item.parentId === parentId);
            let parentNode  = this.nodes.find((node) => node.id === parentId);

            parentNode.hasChildren = hasChildren;
        },
        async destroyNode(node)
        {
            let nodeId   = node.id;
            let parentId = node.parentId;

            //  Destroy children nodes first
            this.findChildren(nodeId).then(() => {
                let nodeIndex = this.nodes.indexOf(this.nodes.find(n => n.id === nodeId));
                this.nodes.splice(nodeIndex, 1);
                this.updateParent(parentId);
            });
        },
        async findChildren(nodeId)
        {
            for(let child of this.nodes)
            {
                if(child.parentId === nodeId)
                {
                    this.destroyNode(child);
                }
            }

            return true
        }
    }
});
