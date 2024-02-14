<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('specifications', function (Blueprint $table) {
            $table->string('manufacturer')->nullable();
            $table->string('product')->nullable();
            $table->string('roof_color')->nullable();
            $table->string('hip_cable')->nullable();
            $table->string('cornice_strip')->nullable();
            $table->string('cornice_return')->nullable();
            $table->string('soffit')->nullable();
            $table->string('roof_layers')->nullable();
            $table->string('stories')->nullable();
            $table->string('roof_pitch')->nullable();
            $table->string('felt')->nullable();
            $table->string('valley_metal')->nullable();
            $table->string('ridge')->nullable();
            $table->string('valley')->nullable();
            $table->string('satellite_dish')->nullable();
            $table->string('low_slope')->nullable();
            $table->string('slope_pitch')->nullable();
            $table->string('roof_type')->nullable();
            $table->string('drip_edge')->nullable();
            $table->string('painted')->nullable();
            $table->string('drip_edge_size')->nullable();
            $table->string('drip_edge_color')->nullable();
            $table->string('exhaust_cap')->nullable();
            $table->string('exhaust_cap_type')->nullable();
            $table->string('exhaust_cap_quantity')->nullable();
            $table->string('exhaust_cap_size')->nullable();
            $table->string('pipe_jack')->nullable();
            $table->string('pipe_jack_type')->nullable();
            $table->string('pipe_jack_size')->nullable();
            $table->string('pipe_jack_quantity')->nullable();
            $table->string('furnace_vent')->nullable();
            $table->string('furnace_chimney_size')->nullable();
            $table->string('furnace_chimney_quantity')->nullable();
            $table->string('chimney_flashing')->nullable();
            $table->string('chimney_flashing_type')->nullable();
            $table->string('chimney_flashing_quantity')->nullable();
            $table->string('chimney_diverter')->nullable();
            $table->string('chimney_diverter_type')->nullable();
            $table->string('chimney_diverter_quantity')->nullable();
            $table->string('skylight_lens')->nullable();
            $table->string('skylight_diverter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('specifications', function (Blueprint $table) {
            $table->dropColumn([
                'manufacturer',
                'product',
                'roof_color',
                'hip_cable',
                'cornice_strip',
                'cornice_return',
                'soffit',
                'roof_layers',
                'stories',
                'roof_pitch',
                'felt',
                'valley_metal',
                'ridge',
                'valley',
                'satellite_dish',
                'low_slope',
                'slope_pitch',
                'roof_type',
                'drip_edge',
                'painted',
                'drip_edge_size',
                'drip_edge_color',
                'exhaust_cap',
                'exhaust_cap_type',
                'exhaust_cap_quantity',
                'exhaust_cap_size',
                'pipe_jack',
                'pipe_jack_type',
                'pipe_jack_size',
                'pipe_jack_quantity',
                'furnace_vent',
                'furnace_chimney_size',
                'furnace_chimney_quantity',
                'chimney_flashing',
                'chimney_flashing_type',
                'chimney_flashing_quantity',
                'chimney_diverter',
                'chimney_diverter_type',
                'chimney_diverter_quantity',
                'skylight_lens',
                'skylight_diverter'
            ]);
        });
    }
};
