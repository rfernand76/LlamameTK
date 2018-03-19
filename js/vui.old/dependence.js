var PATH_JS = "/";
var JQUERY_UI_CSS = "normal";

function dependence(formato) {
    var head = $("head");

    if(GLOBAL_VUI_CSS != undefined){
        var vuiModule = getByName(modulos, "jquery-ui");
        vuiModule.paths[0].path = PATH_JS + "css/jquiryui/"+GLOBAL_VUI_CSS+"/";
    }else if(formato.format.cssFormat != undefined){
        var vuiModule = getByName(modulos, "jquery-ui");
        vuiModule.paths[0].path = PATH_JS + "css/jquiryui/"+formato.format.cssFormat+"/";
    }

    var html = getHtmlDependence(head, formato);
    if (html !== "") {
        var importJs = $(html);
        importJs.appendTo(head);
    }

}

function addDependence(file) {
    var head = $("head");
    if(GLOBAL_VUI_CSS != undefined){
        var vuiModule = getByName(modulos, "jquery-ui");
        vuiModule.paths[0].path = PATH_JS + "css/jquiryui/"+GLOBAL_VUI_CSS+"/";
    }

    var vuiModule = getByName(modulos, file.modulo_name);
    var resource = getByName(vuiModule.resource, file.resource_name);
    var html = loadSource(head, vuiModule, resource)

    if (html !== "") {
        var importJs = $(html);
        importJs.appendTo(head);
    }
}

function addAllDependence() {

    var head = $("head");

    for (var e = 0; e < modulos.length; e++) {
        var vuiModule = modulos[e];

        for (var i = 0; i < vuiModule.resource.length; i++) {
            var resource = vuiModule.resource[i];

            if (resource.src !== undefined) {
                var html = loadSource(head, vuiModule, resource);
                var importJs = $(html);

                importJs.appendTo(head);
            }
        }
    }
}

var modulos =
        [
            {
                name: "jquery-ui"
                , paths: [
                      {name: "css", path: PATH_JS + "css/jquiryui/"+JQUERY_UI_CSS+"/"}
                    , {name: "custom", path: PATH_JS + "js/jquery-ui-1.9.1.custom/js/"}
                    , {name: "ui", path: PATH_JS + "js/jquery-ui-1.9.1.custom/development-bundle/ui/"}
                    , {name: "external", path: PATH_JS + "js/jquery-ui-1.9.1.custom/development-bundle/external/"}
                ]

                , resource:
                        [
                              {src: "jquery-1.8.2.js", path: "custom", name: "jquery.base"}
                            , {src: "jquery.ui.core.js", path: "ui", name: "jquery.ui.core"}
                            , {src: "jquery.ui.widget.js", path: "ui", name: "jquery.ui.widget"}
                            , {src: "jquery.ui.mouse.js", path: "ui", name: "jquery.ui.mouse"}
                            , {src: "jquery.bgiframe-2.1.2.js", path: "external", name: "jquery.bgiframe"}
                            , {src: "jquery.mousewheel.js", path: "external", name: "jquery.mousewheel"}
                            , {src: "jquery-ui.css", path: "css", name: "jquery-ui.css", type: "css"}
                            , {src: "jquery.ui.dialog.js", path: "ui", name: "dialog"}

                            , {src: "jquery.ui.draggable.js", path: "ui", name: "draggable"}
                            , {src: "jquery.ui.droppable.js", path: "ui", name: "droppable"}
                            , {src: "jquery.ui.resizable.js", path: "ui", name: "resizable"}
                            , {src: "jquery.ui.position.js", path: "ui", name: "position"}
                            , {src: "jquery.ui.button.js", path: "ui", name: "button"}
                            , {src: "jquery.ui.tooltip.js", path: "ui", name: "tooltip"}

                            , {name: "core", dependence: [
                                    {modulo_name: "jquery-ui", resource_name: "jquery.base"}
                                    , {modulo_name: "jquery-ui", resource_name: "jquery.ui.core"}
                                    , {modulo_name: "jquery-ui", resource_name: "jquery.ui.widget"}
                                    , {modulo_name: "jquery-ui", resource_name: "jquery.ui.mouse"}
                                    , {modulo_name: "jquery-ui", resource_name: "jquery.bgiframe"}
                                    , {modulo_name: "jquery-ui", resource_name: "jquery.mousewheel"}
                                    , {modulo_name: "jquery-ui", resource_name: "jquery-ui.css"}
                                    , {modulo_name: "jquery-ui", resource_name: "dialog"}

                                    , {modulo_name: "jquery-ui", resource_name: "draggable"}
                                    , {modulo_name: "jquery-ui", resource_name: "droppable"}
                                    , {modulo_name: "jquery-ui", resource_name: "resizable"}
                                    , {modulo_name: "jquery-ui", resource_name: "position"}
                                    , {modulo_name: "jquery-ui", resource_name: "button"}
                                ]}



                            , {src: "jquery.ui.accordion.js", name: "accordion", path: "ui", dependence: [{modulo_name: "jquery-ui", resource_name: "core"}]}
                            , {src: "jquery.ui.tabs.js", name: "tabs", path: "ui", dependence: [{modulo_name: "jquery-ui", resource_name: "core"}]}
                            , {src: "jquery.ui.datepicker.js", name: "datepicker", path: "ui", dependence: [{modulo_name: "jquery-ui", resource_name: "core"}]}
                            , {src: "jquery.ui.progressbar.js", name: "progressbar", path: "ui", dependence: [{modulo_name: "jquery-ui", resource_name: "core"}]}
                            , {src: "jquery.ui.spinner.js", name: "spinner", path: "ui", dependence: [{modulo_name: "jquery-ui", resource_name: "core"}]}
                            , {src: "jquery.ui.slider.js", name: "slider", path: "ui", dependence: [{modulo_name: "jquery-ui", resource_name: "core"}]}


                            , {src: "jquery.ui.effect.js", name: "effect", path: "ui", dependence: [{modulo_name: "jquery-ui", resource_name: "core"}]}

                        ]
            }

            , {
                name: "flexigrid"
                , paths: [
                    {name: "js", path: PATH_JS + "js/flexigrid-1.1/js/"}
                    , {name: "css", path: PATH_JS + "js/flexigrid-1.1/css/"}
                ]

                , resource:
                        [
                            {src: "flexigrid.css", path: "css", name: "flexigrid.css", type: "css"}
                            , {src: "flexigrid.pack.js", path: "js", name: "pack"}
                            , {src: "flexigrid.js", path: "js", name: "flexigrid", dependence: [{modulo_name: "flexigrid", resource_name: "pack"}, {modulo_name: "flexigrid", resource_name: "flexigrid.css"}]}
                        ]
            }

            , {
                name: "dynatree"
                , paths: [
                    {name: "js", path: PATH_JS + "js/dynatree-1.2.4/src/"}
                    , {name: "css", path: PATH_JS + "js/dynatree-1.2.4/src/skin/"}
                ]

                , resource:
                        [
                            {src: "ui.dynatree.css", path: "css", name: "css", type: "css"}
                            , {src: "jquery.dynatree.js", path: "js", name: "dynatree", dependence: [{modulo_name: "dynatree", resource_name: "css"}]}
                        ]
            }

            , {
                name: "vui"
                , paths: [
                    {name: "js", path: PATH_JS + "js/vui/"}
                    , {name: "css", path: PATH_JS + "js/vui/"}
                ]

                , resource:
                        [
                            {src: "run.js", path: "js", name: "run"}
                            , {src: "visualUI.css", path: "css", name: "visualUI.css", type: "css"}

                            , {name: "core", dependence: [
                                    {modulo_name: "jquery-ui", resource_name: "core"}
                                    , {modulo_name: "vui", resource_name: "run"}
                                    , {modulo_name: "vui", resource_name: "visualUI"}
                                    , {modulo_name: "vui", resource_name: "visualUI.css"}
                                ]}

                            , {src: "AcordionClass.js", name: "AcordionClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "jquery-ui", resource_name: "accordion"}]}
                            , {src: "TabClass.js", name: "TabClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "jquery-ui", resource_name: "tabs"}]}
                            , {src: "DatepickerClass.js", name: "DatepickerClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "jquery-ui", resource_name: "datepicker"}]}
                            , {src: "ProgressbarClass.js", name: "ProgressbarClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "jquery-ui", resource_name: "progressbar"}]}
                            , {src: "JQBotonClass.js", name: "JQBotonClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "jquery-ui", resource_name: "button"}]}
                            , {src: "SpinnerClass.js", name: "SpinnerClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "jquery-ui", resource_name: "spinner"}]}
                            , {src: "SliderClass.js", name: "SliderClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "jquery-ui", resource_name: "slider"}]}
                            , {src: "ToolbarClass.js", name: "ToolbarClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "jquery-ui", resource_name: "button"}]}

                            , {src: "FlexiGridClass.js", name: "FlexiGridClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "flexigrid", resource_name: "flexigrid"}]}
                            , {src: "DynatreeClass.js", name: "DynatreeClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "dynatree", resource_name: "dynatree"}]}

                            , {src: "PollClass.js", name: "PollClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "jquery-ui", resource_name: "button"}]}
                            , {src: "FieldsetClass.js", name: "FieldsetClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}, {modulo_name: "jquery-ui", resource_name: "core"}]}
                            , {src: "BotonClass.js", name: "BotonClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "InputClass.js", name: "InputClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "LabelClass.js", name: "LabelClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "ComboClass.js", name: "ComboClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "CheckClass.js", name: "CheckClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "RadioClass.js", name: "RadioClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "TextAreaClass.js", name: "TextAreaClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "LinkClass.js", name: "LinkClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "DivClass.js", name: "DivClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "PanelClass.js", name: "PanelClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "ImagenClass.js", name: "ImagenClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "FileClass.js", name: "FileClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                            , {src: "PasswordClass.js", name: "PasswordClass", path: "js", dependence: [{modulo_name: "vui", resource_name: "core"}]}
                        ]
            }
        ]


function getHtmlDependence(head, formato) {
    var html = "";
    var fields = formato.fields;
    var vuiModule = getByName(modulos, "vui");

    for (var i = 0; i < fields.length; i++) {
        var resource = getByName(vuiModule.resource, fields[i].subclass);
        html = html + loadSource(head, vuiModule, resource);
    }

    return html;
}

var scriptCargados = new Array();
function isLoad(name) {
    for (var i = 0; i < scriptCargados.length; i++) {
        if (scriptCargados[i] === name) {
            return true;
        }
    }

    return false;
}

function loadSource(head, vuiModule, resource) {
    var path = getByName(vuiModule.paths, resource.path);
    var scr = path.path + resource.src;
    var html = getDependeceResource(head, resource);

    if (!isLoad(scr)) {
        if (resource.type === "css") {
            html = html + '<link rel="stylesheet" href="' + scr + '"/>\n'
            scriptCargados.push(scr);

        } else if (!isLoadScript(head, resource)) {
            html = html + '<script src="' + scr + '"></script>\n'
            scriptCargados.push(scr);
        }
    }


    return html;
}

function getDependeceResource(head, resource) {
    var html = "";
    var dependence = resource.dependence;

    if (dependence !== undefined) {
        for (var i = 0; i < dependence.length; i++) {
            var obj = dependence[i];
            var modulo = getByName(modulos, obj.modulo_name);
            var subResource = getByName(modulo.resource, obj.resource_name);

            if (subResource !== undefined) {
                if (subResource.src !== undefined) {
                    html = html + loadSource(head, modulo, subResource);
                }

                if (subResource.dependence !== undefined) {
                    html = html + getDependeceResource(head, subResource);
                }
            }

        }
    }

    return html;
}

function isLoadScript(head, scr) {
    var ret = false;
    head.find("script").each(function() {
        var obj = $(this);
        if (obj.attr("src") === scr) {
            ret = true;
        }
    });

    return ret;
}


function getByName(list, name) {
    for (var i = 0; i < list.length; i++) {
        if (list[i].name === name) {
            return list[i];
        }
    }
}
