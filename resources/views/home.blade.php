@extends('layout.jump')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    System

                    <div class="pull-right">
                        <location v-if="auth"></location>
                    </div>

                </div>
                <div class="panel-body system-select">
                    <system-select :prefetch="pre" v-on:update="updateSystems"></system-select>
                </div>
            </div>
        </div>
    </div>

    <transition name="fade">
        <div class="row" v-show="systemID">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Gate Range
                        <span class="pull-right">
                            Range:
                            <range-select id="gate" :max="25" :selected="10" :system="systemID" v-on:change="rangeChange"></range-select>
                        </span>
                    </div>

                    <div class="panel-body">
                        <grid :range="range" :system="systemID" type="gate"></grid>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Jump Range
                        <span class="pull-right">
                                JDC:
                                <range-select id="jdc" :max="5" :selected="5" :system="systemID" v-on:change="jdcChange"></range-select>
                                <input type="checkbox" name="jump-type" v-model="blopsJDC">
                            </span>
                    </div>

                    <div class="panel-body">
                        <grid :range="lightyears" :system="systemID" type="jump"></grid>
                    </div>
                </div>
            </div>
        </div>
    </transition>

@endsection