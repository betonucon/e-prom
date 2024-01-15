                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                            <a class="nav-link menu-link" href="{{url('home')}}">
                                <i class="mdi mdi-speedometer"></i> <span  >Dashboard</span>
                            </a>
                        </li>
                        <!-- admin -->
                        @if(Auth::user()->role_id==1)
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('home')}}">
                                    <i class="mdi mdi-speedometer"></i> <span  >Sales Performance</span>
                                </a>
                            </li>
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('employe')}}">
                                    <i class="mdi mdi-account-circle-outline"></i> <span  >Employe</span>
                                </a>
                            </li>
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('customer')}}">
                                    <i class="mdi mdi-account-circle-outline"></i> <span  >Customer</span>
                                </a>
                            </li>
                        @endif
                        <!-- kadis operasional-->
                        @if(Auth::user()->role_id==7)
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('project')}}">
                                    <i class="mdi mdi-cube-outline"></i> <span  >Konf RABOB</span>
                                </a>
                            </li>
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('kontrak')}}">
                                    <i class="mdi mdi-cube-outline"></i> <span  >Management Project</span>
                                </a>
                            </li>
                        @endif
                        <!-- kadis Komersil-->
                        @if(Auth::user()->role_id==4)
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('project')}}">
                                    <i class="mdi mdi-cube-outline"></i> <span  >Konf RABOB</span>
                                </a>
                            </li>
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('kontrak')}}">
                                    <i class="mdi mdi-cube-outline"></i> <span  >Management Project</span>
                                </a>
                            </li>
                        @endif
                        <!-- sales-->
                        @if(Auth::user()->role_id==6)
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('customer')}}">
                                    <i class="mdi mdi-account-circle-outline"></i> <span  >Customer</span>
                                </a>
                            </li>
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('project')}}">
                                    <i class="mdi mdi-cube-outline"></i> <span  >RABOB</span>
                                </a>
                            </li>
                            
                        @endif
                        @if(Auth::user()->role_id==3)
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('sales')}}">
                                    <i class="mdi mdi-speedometer"></i> <span  >Sales Performance</span>
                                </a>
                            </li>
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('project')}}">
                                @if(count_approve()>0)
                                <i class="mdi mdi-cube-outline"></i> <span  >Konf RABOB</span>
                                @else
                                <i class="mdi mdi-cube-outline"></i> <span  >Konf RABOB</span>
                                @endif
                                    
                                </a>
                            </li>
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('kontrak')}}">
                                    <i class="mdi mdi-cube-outline"></i> <span  >Management Project</span>
                                </a>
                            </li>
                        @endif
                        <!-- Direktur operasiona-->
                        @if(Auth::user()->role_id==2)
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('home')}}">
                                    <i class="mdi mdi-speedometer"></i> <span  >Sales Performance</span>
                                </a>
                            </li>
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('project')}}">
                                    <i class="mdi mdi-cube-outline"></i> <span  >Konf Rencana Project</span>
                                </a>
                            </li>
                            <li class="nav-item" style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                                <a class="nav-link menu-link" href="{{url('kontrak')}}">
                                    <i class="mdi mdi-cube-outline"></i> <span  >Management Project</span>
                                </a>
                            </li>
                        @endif
                       
                        @if(count_pm()>0)
                        <li class="nav-item"  style="background: #ebebeb1a; border-bottom: solid 1px #dadaef;">
                            <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="mdi mdi-layers-triple-outline"></i> <span  >Management Project</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarDashboards">
                                <ul class="nav nav-sm flex-column" style="background: #e1d2d25e;">
                                   
                                        <li class="nav-item">
                                            <a href="{{url('kontrak/pm')}}" class="nav-link"  >Project</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('pekerjaan')}}" class="nav-link"  >Pekerjaan</a>
                                        </li>
                                    
                                </ul>
                            </div>
                        </li>
                        @endif
                        
                        

                    </ul>