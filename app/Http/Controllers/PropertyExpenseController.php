<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyExpenseRequest;
use App\Models\Property;
use App\Models\PropertyExpense;
use App\Models\PropertyExpenseCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyExpenseController extends Controller
{
    public function show(Request $request, $propertyId)
    {
        $propertyExpenses = PropertyExpense::query()
            ->with('property')
            ->where('property_id', $propertyId)
            ->when($request->input('search'), function ($query, $search) {
                $query
                    ->where('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            })
            ->orderBy('payment_date','desc')
            ->paginate(10)
            ->withQueryString()
            ->through(fn($propertyExpense) => [
                'id' => $propertyExpense->id,
                'description' => $propertyExpense->description,
                'category' => $propertyExpense->propertyExpenseCategory->name,
                'payment_date' => Carbon::parse($propertyExpense->payment_date)->format('d-M-Y'),
                'payment_amount' => $propertyExpense->payment_amount,
                'receipt_id' => $propertyExpense->receipt_id,
                'supplier' => $propertyExpense->property->supplier,
            ]);

        $property = Property::find($propertyId);
        return Inertia('PropertyExpense/Show', compact('property', 'propertyExpenses'));
    }

    public function createPropertyExpense ($property_id)
    {
        $propertyExpenseCategories = PropertyExpenseCategory::all()->toArray();
        return Inertia('PropertyExpense/Edit',
            ['propertyExpenseCategories' => $propertyExpenseCategories,'property_id' => $property_id,]);
    }

    public function store(StorePropertyExpenseRequest $request)
    {
        $propertyExpense = $request->all();
        if ($request->input('id') > 0) {
            $propertyExpense_data = $request->all();
            $propertyExpense = PropertyExpense::find($request->input('id'));
            $propertyExpense->update($propertyExpense_data);
        } else {
            $propertyExpense['company_id'] = Auth::user()->company_id;
            $propertyExpense = PropertyExpense::create($propertyExpense);
        }

        if ($request->hasfile('attachmentFiles')) {
            $userId = Auth::user()->id;
            $propertyExpenseId = $propertyExpense->id;
            $companyId = Auth::user()->company_id;
            foreach ($request->file('attachmentFiles') as $file) {
                $attachmentFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();
                $attachmentFilePath = $file->storeAs('public/propertyExpense_attachment_files/'.$companyId .'/'. $userId . '/' . $propertyExpenseId, $attachmentFileName);
                $propertyExpense->propertyExpenseAttachmentFiles()->create([
                    'company_id' => Auth::user()->company_id,
                    'attachment_file_name' => $attachmentFileName,
                    'attachment_file' => $attachmentFilePath,
                ]);
            }
        }
        return redirect()->route('property-expense.show', $propertyExpense->property_id);
    }

    public function edit($propertyExpense_id)
    {
        $propertyExpenses = PropertyExpense::find($propertyExpense_id);
        $propertyExpenses->load('propertyExpenseAttachmentFiles');
        $propertyExpenseCategories = PropertyExpenseCategory::all()->toArray();
        return Inertia('PropertyExpense/Edit',
            ['propertyExpenseCategories' => $propertyExpenseCategories,'propertyExpenses' => $propertyExpenses]);
    }

    public function destroy(PropertyExpense $propertyExpense)
    {
        $propertyExpense->delete();
        return redirect()->route('property-expense.show', $propertyExpense->property_id);
    }

    public function duplicate($id)
    {
        $original = PropertyExpense::find($id);
        $duplicate = $original->replicate();
        $duplicate->save();
        return redirect()->route('property-expense.show', $original->property_id);
    }
}
