{% extends file="base.tpl" %}
{% block name="head" %}
    {% js file="set.js" %}
    {% css file="set.css" %}
{% /block %}

{% block name="content" %}
    <h1>Set Configuration</h1>

    <ol id="config-containers">
        <li id="tab-off"{% if $config.function == 'off' %} class="ui-selected"{% /if %}><span class="label">Off</span></li>
        <li id="tab-solid"{% if $config.function == 'solid' %} class="ui-selected"{% /if %}><span class="label">Solid</span></li>
        <li id="tab-pulse"{% if $config.function == 'pulse' %} class="ui-selected"{% /if %}><span class="label">Pulse</span></li>
        <li id="tab-dual"{% if $config.function == 'dual' %} class="ui-selected"{% /if %}><span class="label">Dual</span></li>
        <li id="tab-multi"{% if $config.function == 'multi' %} class="ui-selected"{% /if %}><span class="label">Multi</span></li>
    </ol>

    <div id="properties-solid" class="properties{% if $config.function == 'solid' %} show{% /if %}">
        <form id="solid-form">
            <input type="hidden" name="function" value="solid" />
            <input id="solid-red" type="hidden" name="red" />
            <input id="solid-green" type="hidden" name="green" />
            <input id="solid-blue" type="hidden" name="blue" />

            <div id="solid-swatch" class="swatch ui-widget-content ui-corner-all"></div>
            <div class="color-slider-wrap">
                <label>Red</label>
                <div class="color-slider red" data-match="#solid-red" data-default="{% if isset($config.solid_rgb.red) %}{% $config.solid_rgb.red %}{% /if %}"></div>
            </div>
            <div class="color-slider-wrap">
                <label>Green</label>
                <div class="color-slider green" data-match="#solid-green" data-default="{% if isset($config.solid_rgb.green) %}{% $config.solid_rgb.green %}{% /if %}"></div>
            </div>
            <div class="color-slider-wrap">
                <label>Blue</label>
                <div class="color-slider blue" data-match="#solid-blue" data-default="{% if isset($config.solid_rgb.blue) %}{% $config.solid_rgb.blue %}{% /if %}"></div>
            </div>
            <br />
            <div class="pull-left"><button id="solid-submit" class="pull-left">Submit</button></div>
        </form>
    </div>

    <div id="properties-pulse" class="properties{% if $config.function == 'pulse' %} show {% /if %}">
        <form id="pulse-form">
            <input type="hidden" name="function" value="pulse" />
            <input id="pulse-red" type="hidden" name="red" />
            <input id="pulse-green" type="hidden" name="green" />
            <input id="pulse-blue" type="hidden" name="blue" />

            <div id="pulse-swatch" class="swatch ui-widget-content ui-corner-all"></div>
            <div class="color-slider-wrap">
                <label>Red</label>
                <div class="color-slider red" data-match="#pulse-red" data-default="{% if isset($config.pulse_rgb.red) %}{% $config.pulse_rgb.red %}{% /if %}"></div>
            </div>
            <div class="color-slider-wrap">
                <label>Green</label>
                <div class="color-slider green" data-match="#pulse-green" data-default="{% if isset($config.pulse_rgb.green) %}{% $config.pulse_rgb.green %}{% /if %}"></div>
            </div>
            <div class="color-slider-wrap">
                <label>Blue</label>
                <div class="color-slider blue" data-match="#pulse-blue" data-default="{% if isset($config.pulse_rgb.blue) %}{% $config.pulse_rgb.blue %}{% /if %}"></div>
            </div>
            <br /><br />
            <div class="pull-left">
                <label for="pulse-wait">Wait</label>
                <div id="pulse-wait" name="wait" class="wait-slider" data-time="{% if isset($config.pulse_wait_time) %}{% $config.pulse_wait_time %}{% else %}1{% /if %}"></div>
                <br /><br />
                <label for="pulse-hold">Hold</label>
                <div id="pulse-hold" name="hold" class="hold-slider" data-time="{% if isset($config.pulse_hold_time) %}{% $config.pulse_hold_time %}{% else %}1{% /if %}"></div>
                <br /><br />
                <input class="form-wait" type="hidden" name="wait" />
                <input class="form-hold" type="hidden" name="hold" />
                <button id="pulse-submit" class="pull-left">Submit</button>
            </div>
        </form>
    </div>

    <div id="properties-dual" class="properties{% if $config.function == 'dual' %} show {% /if %}">
        <form id="dual-form">
            <input type="hidden" name="function" value="dual" />
            <div>
                <label for="dual1-red">Red</label>
                <input type="text" id="dual1-red" name="red1" class="color"
                       value="{% if isset($config.dual_rgb_0.red) %}{% $config.dual_rgb_0.red %}{% /if %}" />
            </div>
            <div>
                <label for="dual1-green">Green</label>
                <input type="text" id="dual1-green" name="green1" class="color"
                       value="{% if isset($config.dual_rgb_0.green) %}{% $config.dual_rgb_0.green %}{% /if %}" />
            </div>
            <div>
                <label for="dual1-blue">Blue</label>
                <input type="text" id="dual1-blue" name="blue1" class="color"
                       value="{% if isset($config.dual_rgb_0.blue) %}{% $config.dual_rgb_0.blue %}{% /if %}" />
            </div>
            <br />
            <div>
                <label for="dual2-red">Red</label>
                <input type="text" id="dual2-red" name="red2" class="color"
                       value="{% if isset($config.dual_rgb_1.red) %}{% $config.dual_rgb_1.red %}{% /if %}" />
            </div>
            <div>
                <label for="dual2-green">Green</label>
                <input type="text" id="dual2-green" name="green2" class="color"
                       value="{% if isset($config.dual_rgb_1.green) %}{% $config.dual_rgb_1.green %}{% /if %}" />
            </div>
            <div>
                <label for="dual2-blue">Blue</label>
                <input type="text" id="dual2-blue" name="blue2" class="color"
                       value="{% if isset($config.dual_rgb_1.blue) %}{% $config.dual_rgb_1.blue %}{% /if %}" />
            </div>
            <br />
            <div>
                <label for="dual-wait">Wait</label>
                <div id="dual-wait" name="wait" class="wait-slider" data-time="{% if isset($config.pulse_wait_time) %}{% $config.pulse_wait_time %}{% else %}1{% /if %}"></div>
            </div>
            <br />
            <div>
                <label for="dual-hold">Hold</label>
                <div id="dual-hold" name="hold" class="hold-slider" data-time="{% if isset($config.pulse_hold_time) %}{% $config.pulse_hold_time %}{% else %}1{% /if %}"></div>
            </div>
            <br />
            <input type="hidden" class="form-wait" name="wait" />
            <input type="hidden" class="form-hold" name="hold" />
            <button id="dual-submit">Submit</button>
        </form>
    </div>

    <div id="properties-multi" class="properties{% if $config.function == 'multi' %} show {% /if %}">
        <form id="multi-form">
            <input type="hidden" name="function" value="multi" />
            <div>
                <label>Red</label>
                <input type="text" name="multi[0][red]" class="color"
                       value="{% if isset($config.multi_array.0.red) %}{% $config.multi_array.0.red %}{% /if %}" />
                <input type="text" name="multi[1][red]" class="color"
                       value="{% if isset($config.multi_array.1.red) %}{% $config.multi_array.1.red %}{% /if %}" />
                <input type="text" name="multi[2][red]" class="color"
                       value="{% if isset($config.multi_array.2.red) %}{% $config.multi_array.2.red %}{% /if %}" />
                <input type="text" name="multi[3][red]" class="color"
                       value="{% if isset($config.multi_array.3.red) %}{% $config.multi_array.3.red %}{% /if %}" />
                <input type="text" name="multi[4][red]" class="color"
                       value="{% if isset($config.multi_array.4.red) %}{% $config.multi_array.4.red %}{% /if %}" />
                <input type="text" name="multi[5][red]" class="color"
                       value="{% if isset($config.multi_array.5.red) %}{% $config.multi_array.5.red %}{% /if %}" />
            </div>
            <div>
                <label>Green</label>
                <input type="text" name="multi[0][green]" class="color"
                       value="{% if isset($config.multi_array.0.green) %}{% $config.multi_array.0.green %}{% /if %}" />
                <input type="text" name="multi[1][green]" class="color"
                       value="{% if isset($config.multi_array.1.green) %}{% $config.multi_array.1.green %}{% /if %}" />
                <input type="text" name="multi[2][green]" class="color"
                       value="{% if isset($config.multi_array.2.green) %}{% $config.multi_array.2.green %}{% /if %}" />
                <input type="text" name="multi[3][green]" class="color"
                       value="{% if isset($config.multi_array.3.green) %}{% $config.multi_array.3.green %}{% /if %}" />
                <input type="text" name="multi[4][green]" class="color"
                       value="{% if isset($config.multi_array.4.green) %}{% $config.multi_array.4.green %}{% /if %}" />
                <input type="text" name="multi[5][green]" class="color"
                       value="{% if isset($config.multi_array.5.green) %}{% $config.multi_array.5.green %}{% /if %}" />
            </div>
            <div>
                <label>Blue</label>
                <input type="text" name="multi[0][blue]" class="color"
                       value="{% if isset($config.multi_array.0.blue) %}{% $config.multi_array.0.blue %}{% /if %}" />
                <input type="text" name="multi[1][blue]" class="color"
                       value="{% if isset($config.multi_array.1.blue) %}{% $config.multi_array.1.blue %}{% /if %}" />
                <input type="text" name="multi[2][blue]" class="color"
                       value="{% if isset($config.multi_array.2.blue) %}{% $config.multi_array.2.blue %}{% /if %}" />
                <input type="text" name="multi[3][blue]" class="color"
                       value="{% if isset($config.multi_array.3.blue) %}{% $config.multi_array.3.blue %}{% /if %}" />
                <input type="text" name="multi[4][blue]" class="color"
                       value="{% if isset($config.multi_array.4.blue) %}{% $config.multi_array.4.blue %}{% /if %}" />
                <input type="text" name="multi[5][blue]" class="color"
                       value="{% if isset($config.multi_array.5.blue) %}{% $config.multi_array.5.blue %}{% /if %}" />
            </div>
            <br />
            <div>
                <label>Wait</label>
                <div id="multi-wait" name="wait" class="wait-slider" data-time="{% if isset($config.pulse_wait_time) %}{% $config.pulse_wait_time %}{% else %}1{% /if %}"></div>
            </div>
            <br />
            <div>
                <label>Hold</label>
                <div id="multi-hold" name="hold" class="hold-slider" data-time="{% if isset($config.pulse_hold_time) %}{% $config.pulse_hold_time %}{% else %}1{% /if %}"></div>
            </div>
            <br />
            <input type="hidden" class="form-wait" name="wait" />
            <input type="hidden" class="form-hold" name="hold" />
            <button id="multi-submit">Submit</button>
        </form>
    </div>
{% /block %}
