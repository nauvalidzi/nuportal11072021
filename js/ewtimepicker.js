/**
 * Create Time Picker (for PHPMaker 2021)
 * @license Copyright (c) e.World Technology Limited. All rights reserved.
 */
ew.createTimePicker=function(i,t,e){if(!t.includes("$rowindex$")){var o=jQuery,n=ew.getElement(t,i),p=o(n);if(!p.hasClass("ui-timepicker-input")){e.timeFormat&&":"!=ew.TIME_SEPARATOR&&(e.timeFormat=e.timeFormat.replace(/:/g,ew.TIME_SEPARATOR));var r=!o.isBoolean(e.inputGroup)||e.inputGroup;if(delete e.inputGroup,p.timepicker(e).on("showTimepicker",(function(){n.timepickerObj.list.width(p.outerWidth()-2)})),p.focus((function(){p.tooltip("hide").tooltip("disable")})).blur((function(){p.tooltip("enable")})),r){var u=o('<button type="button"><i class="far fa-clock"></i></button>').addClass("btn btn-default").on("click",(function(){p.timepicker("show")}));p.wrap('<div class="input-group"></div>').after(o('<div class="input-group-append"></div>').append(u))}}}};