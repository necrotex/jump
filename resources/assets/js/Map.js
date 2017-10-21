class Map {

    constructor(data, width, height, vue) {


        this.map_data = JSON.parse(data.map);
        this.data = data.data;
        this.raphael = require('raphael');
        this.paper = this.raphael(document.getElementById('map'), width, height);
        this.vue = vue;
    }

    draw() {

        this.drawConnections(this.map_data.map.connections);
        this.drawSystemNames(this.map_data.map.systems);
        this.drawSystems(this.map_data.map.systems);
    }

    drawConnections(connections){

        for(let i in connections) {

            let x1 = connections[i]['x1'];
            let y1 = connections[i]['y1'];
            let x2 = connections[i]['x2'];
            let y2 = connections[i]['y2'];

            this.paper.path(`M${x1},${y1}L${x2},${y2}`)
                .attr({stroke:'#C00',width:50, fill:'#c00'});
        }
    }

    drawSystemNames(systems) {

        let drawSystemOffsetX = 42;
        let drawSystemOffsetY = 15;
        let drawSystemSize = 12;

        for (let i in systems) {
            let x = Math.floor(systems[i]['x']);
            let y = Math.floor(systems[i]['y']);

            let name = systems[i]['name'];
            let region = systems[i]['region'];

            this.paper.text(x + drawSystemOffsetX + drawSystemSize/2 + 8, y + drawSystemOffsetY - 6, name)
                .attr({fill:'#000', font:'Helvetica', fontsize: 9});

            if (region != undefined) {
                this.paper.text(x + drawSystemOffsetX + drawSystemSize/2 + 8, y + drawSystemOffsetY - 6, region)
                    .attr({fill:'#00f', font:'Helvetica', fontsize: 9});
            }

        }

    }

    drawSystems(systems) {
        let drawSystemOffsetX = 28;
        let drawSystemOffsetY = 14;
        let drawSystemSize = 12;

        for (let i in systems) {
            let x = Math.floor(systems[i]['x']);
            let y = Math.floor(systems[i]['y']);
            let name = systems[i]['name'];
            let stn = systems[i]['hasStation'];

            let drawXMax = Math.max(drawXMax, Math.floor(x * 1) + drawSystemOffsetX);
            let drawYMax = Math.max(drawYMax, Math.floor(y * 1) + drawSystemOffsetY);

            let data = this.data[name];
            let color;

            if(typeof data == "undefined") {
                color = '#000000';
            } else {
                color = this.detlaToColor(data.delta);
            }

            if (stn) {
                let sys = this.paper.rect(x + drawSystemOffsetX - drawSystemSize/2, y + drawSystemOffsetY  - drawSystemSize/2, drawSystemSize, drawSystemSize)
                    .attr({fill: color})
                    .click((event) => {
                        event.preventDefault();
                        if(event.button == 0) {
                            this.vue.openInfoPanel(data);
                        } else if (event.button == 2) {
                            this.vue.openContextMenu(event.screenX, event.screenY)
                        }
                    });
            } else {
                let sys = this.paper.circle(x + drawSystemOffsetX, y + drawSystemOffsetY, drawSystemSize/2)
                    .attr({fill: color})
                    .click((event) => {
                        event.preventDefault();

                        if(event.button == 0) {
                            this.vue.openInfoPanel(data);
                        } else if (event.button == 2) {
                            this.vue.openContextMenu(event.screenX, event.screenY)
                        }
                });
            }

        }
    }

    detlaToColor(delta) {

        switch(true) {
            case (delta < -500):
                return '#ff0000';
            case (delta < -250):
                return '#ff6600';
            case (delta < -50):
                return '#ffcc99';
            case (delta == 0):
                return '#ffffff';
            case (delta > 50):
                return '#ffff99';
            case (delta > 250):
                return '#99ff66';
            case (delta > 500):
                return '#00ff00';
            default:
                return '#ffffff';
        }
    }

}

module.exports = Map;