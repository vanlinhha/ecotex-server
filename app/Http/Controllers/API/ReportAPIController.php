<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUsersAPIRequest;
use App\Http\Requests\API\UpdateUsersAPIRequest;
use App\Models\Brand;
use App\Models\Locations;
use App\Models\Responses;
use App\Models\Users;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\JobPostsRepository;
use App\Repositories\MainCategoryRepository;
use App\Repositories\ProductPostsRepository;
use App\Repositories\ProductsRepository;
use App\Repositories\UsersRepository;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Nahid\Talk\Conversations\Conversation;
use Nahid\Talk\Messages\Message;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use JWTAuth;


class ReportAPIController extends AppBaseController
{
    /** @var  UsersRepository */
    private $usersRepository;
    private $categoryRepository;
    private $mainCategoryRepository;
    private $productsRepository;
    private $productPostsRepository;
    private $jobPostsRepository;

    public function __construct(UsersRepository $usersRepo,
                                CategoryRepository $categoryRepository,
                                MainCategoryRepository $mainCategoryRepo,
                                ProductPostsRepository $productPostsRepository,
                                ProductsRepository $productsRepository,
                                JobPostsRepository $jobPostsRepository)
    {
        $this->usersRepository = $usersRepo;
        $this->categoryRepository = $categoryRepository;
        $this->mainCategoryRepository = $mainCategoryRepo;
        $this->productsRepository = $productsRepository;
        $this->productPostsRepository = $productPostsRepository;
        $this->jobPostsRepository = $jobPostsRepository;
    }

    static function makeInstance(UsersRepository $usersRepo,
                                 CategoryRepository $categoryRepository,
                                 MainCategoryRepository $mainCategoryRepo,
                                 ProductsRepository $productsRepository,
                                 ProductPostsRepository $productPostsRepository,
                                 JobPostsRepository $jobPostsRepository)
    {
        return new self($usersRepo, $categoryRepository, $mainCategoryRepo, $productPostsRepository, $productsRepository, $jobPostsRepository);
    }

    public function index(Request $request)
    {
        $arr = [];

        $arr['total_products'] = $this->productsRepository->all()->count();
        $arr['total_inactivated_users'] = $this->usersRepository->findWhere([['is_activated', '=', 0]])->count();
        $arr['total_activated_users'] = $this->usersRepository->findWhere([['is_activated', '=', 1]])->count();
//        $arr['total_users'] = $this->usersRepository->all()->count();
        $arr['total_conversations'] = Conversation::all()->count();
        $arr['total_messages'] = Message::all()->count();
        $arr['total_location'] = Locations::all()->count();
        $arr['total_brands'] = Brand::all()->count();
        $arr['total_responses'] = Responses::all()->count();
        $arr['total_product_posts'] = $this->productPostsRepository->all()->count();
        $arr['total_job_posts'] = $this->jobPostsRepository->all()->count();
        $arr['total_material_category'] = $this->categoryRepository->findWhere([['type', '=', 'material']])->count();
        $arr['total_product_category'] = $this->categoryRepository->findWhere([['type', '=', 'product']])->count();
        $arr['total_segment_category'] = $this->categoryRepository->findWhere([['type', '=', 'segment']])->count();
        $arr['total_service_category'] = $this->categoryRepository->findWhere([['type', '=', 'service']])->count();
        $arr['total_target_category'] = $this->categoryRepository->findWhere([['type', '=', 'target']])->count();

        $start_date = date('Y-m-d');
        $date = \DateTime::createFromFormat('Y-m-d', $start_date);
        $date->modify('-30 day');

//        $arr['total_users_last_30_days'] = $this->usersRepository->findWhere([['created_at', '>=', $date]])->count();
        $arr['total_inactivated_users_last_30_days'] = $this->usersRepository->findWhere([['created_at', '>=', $date], ['is_activated', '=', 0]])->count();
        $arr['total_activated_users_last_30_days'] = $this->usersRepository->findWhere([['created_at', '>=', $date], ['is_activated', '=', 1]])->count();
        $arr['total_conversations_last_30_days'] = Conversation::where('created_at', '>=', $date)->count();
        $arr['total_messages_last_30_days'] = Message::where('created_at', '>=', $date)->count();
        $arr['total_product_posts_last_30_days'] = $this->productPostsRepository->findWhere([['created_at', '>=', $date]])->count();

        $all_roles = Role::all();
        foreach ($all_roles as $role) {
            $role['number_of_users'] = DB::table('role_user')->where('role_id', '=', $role->id)->count();
        }
        $arr['role_report'] = $all_roles;

        for ($i = 1; $i <= 6; $i++) {
            $temp = [];
            $temp['month'] = date("m-Y", strtotime(date('Y-m-01') . " -$i months"));
            $first_day = date('Y-m-01', strtotime($temp['month']));
            $last_day = date('Y-m-t', strtotime($temp['month']));

            $temp['total_products'] = $this->productsRepository->findWhere([['created_at', '>=', $first_day], ['created_at', '<=', $last_day]])->count();
            $temp['total_inactivated_users'] = $this->usersRepository->findWhere([['is_activated', '=', 0], ['created_at', '>=', $first_day], ['created_at', '<=', $last_day]])->count();
            $temp['total_activated_users'] = $this->usersRepository->findWhere([['is_activated', '=', 1], ['created_at', '>=', $first_day], ['created_at', '<=', $last_day]])->count();
            $temp['total_conversations'] = Conversation::where([['created_at', '>=', $first_day], ['created_at', '<=', $last_day]])->count();
            $temp['total_location'] = Locations::where([['created_at', '>=', $first_day], ['created_at', '<=', $last_day]])->count();
            $temp['total_brands'] = Brand::where([['created_at', '>=', $first_day], ['created_at', '<=', $last_day]])->count();
            $temp['total_responses'] = Responses::where([['created_at', '>=', $first_day], ['created_at', '<=', $last_day]])->count();
            $temp['total_product_posts'] = $this->productPostsRepository->findWhere([['created_at', '>=', $first_day], ['created_at', '<=', $last_day]])->count();
            $temp['total_job_posts'] = $this->jobPostsRepository->findWhere([['created_at', '>=', $first_day], ['created_at', '<=', $last_day]])->count();

            $months[] = $temp;
        }
        $arr['last_6_month'] = $months;

        return $this->sendResponse($arr, 'Report successfully');

    }

}
