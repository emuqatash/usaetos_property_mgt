<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{

    protected $fillable = [
        'job_id', 'manufacturer', 'product', 'roof_color', 'hip_cable', 'cornice_strip', 'cornice_return', 'soffit',
        'roof_layers', 'stories', 'roof_pitch', 'felt', 'valley_metal', 'ridge', 'valley', 'satellite_dish',
        'low_slope', 'slope_pitch', 'roof_type', 'drip_edge', 'painted', 'drip_edge_size', 'drip_edge_color',
        'exhaust_cap', 'exhaust_cap_type', 'exhaust_cap_quantity', 'exhaust_cap_size', 'pipe_jack', 'pipe_jack_type',
        'pipe_jack_size', 'pipe_jack_quantity', 'furnace_vent', 'furnace_chimney_size', 'furnace_chimney_quantity',
        'chimney_flashing', 'chimney_flashing_type', 'chimney_flashing_quantity', 'chimney_diverter',
        'chimney_diverter_type', 'chimney_diverter_quantity', 'skylight_lens','skylight_diverter',
        'comments', 'company_id',
    ];

//    protected $with = ['specificationAttachmentFiles'];

    public function job(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function specificationAttachmentFiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SpecificationAttachmentFile::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyScope());
    }
}
