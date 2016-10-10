<template>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        System

                        <div class="pull-right">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Use my current location"><i class="material-icons">my_location</i></a>
                        </div>

                    </div>

                    <div class="panel-body system-select">
                        <select type="text" class="form-control" id="system" v-model="system" placeholder="System"></select>
                    </div>
                </div>
            </div>
        </div>

</template>

<script>
    require('select2');

    export default {
        data(){
            return{
                system: ''
            }
        },

      mounted() {
          console.log('system module loaded');

          $('[data-toggle="tooltip"]').tooltip();

          $("#system").select2({
              minimumInputLength: 2,
              ajax: {
                  url: '/api/systems/autocomplete',
                  dataType: 'json',
                  placeholder: 'Enter a System',
                  delay: 250,
                  processResults: function (data) {
                      return {
                          results: $.map(data, function (item) {
                              return {
                                  text: item.solarSystemName,
                                  slug: item.solarSystemID,
                                  id: item.solarSystemID
                              }
                          })
                      };
                  }
              }
          });


      }
    }
</script>
