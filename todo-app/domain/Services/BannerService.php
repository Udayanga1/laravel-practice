<?php

namespace domain\Services;

use App\Models\Banner;

class BannerService
{
    protected $banner;

    public function __construct()
    {
        $this->banner = new Banner();
    }

    public function all()
    {
        return $this->banner->all();
    }

    public function store($data)
    {
        $this->banner->create($data);
    }

    public function delete($banner_id)
    {
        $banner = $this->banner->find($banner_id);
        $banner->delete();


    }
    
    public function status($banner_id)
    {
        $banner = $this->banner->find($banner_id);
        $banner->done = 1;
        $banner->update();

    }
}