<?php

namespace App\View\Components\Backend\Merchant;

use App\Models\Backend\Merchant;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ViewCard extends Component
{
    private $mid;
    /**
     * Create a new component instance.
     */
    public function __construct($merchantId)
    {
        $this->mid = $merchantId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $merchant = Merchant::with('user')->withCount('parcels')->findOrFail($this->mid);
        // dd($merchant);
        return view('components.backend.merchant.view-card', compact('merchant'));
    }

    public function shouldRender()
    {
        return Merchant::where('id', $this->mid)->exists();
    }
}
