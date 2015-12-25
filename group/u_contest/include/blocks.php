
      <div class="contest__content">
        <div class="contest__step contest__intro center contest__step--active">
          <h1>U_creative</h1>
          <p>
            Участники проекта U_CONCEPT успешно создали арт-проекты.<br>
            Пришла Ваша очередь показать свои творческие таланты. <br>
            Место проведения проекта <nobr>– <span>г. Екатеринбург.</span></nobr>
          </p>
          <div class="row contest__features">
            <div class="col-xs-12 col-sm-4 feature">
              <div class="feature__image"><img src="/group/u_contest/images/icon-1.png" alt="" width="130"/></div>
              <div class="feature__text">Ответьте на несколько<br/> простых вопросов.</div>
            </div>
            <div class="col-xs-12 col-sm-4 feature">
              <div class="feature__image"><img src="/group/u_contest/images/icon-2.png" alt="" width="130"/></div>
              <div class="feature__text">Создайте уникальный дизайн<br/> для свитшота.</div>
            </div>
            <div class="col-xs-12 col-sm-4 feature">
              <div class="feature__image"><img src="/group/u_contest/images/icon-3.png" alt="" width="122"/></div>
              <div class="feature__text">Получите авторскую вещь<br/>в качестве комплимента*. </div>
            </div>
          </div>
          <form method="POST" action="/">
            <input id="agree" type="checkbox" name="agreement" class="checkbox"/>
            <label for="agree">Я согласен с <a href="#Rules" data-toggle="modal">правилами участия</a></label><br/>
            <button type="submit" class="button">начать</button><br/>
            <div class="error">Пожалуйста, подтвердите свое согласие<br/>с правилами участия, чтобы продолжить.</div>
          </form><br/><small>*Доставка осуществляется только в городе Екатеринбург.</small>
        </div>
        <div class="contest__question contest__step contest__step--2">
          <h1 class="center">ВОПРОСЫ. <span>1/3</span></h1>
          <h3 class="center">Откуда вы узнали о сигаретах Kent Explore?</h3>
          <form method="POST" action="/">
            <textarea placeholder="Напишите свой ответ" class="textarea"></textarea>
            <div class="center"><br/>
              <button type="submit" class="button">ответить</button><br/>
              <div class="error">Пожалуйста, ответьте на вопрос<br/>для продолжения участия. </div>
            </div>
          </form>
        </div>
        <div class="contest__question contest__step contest__step--3">
          <h1 class="center">ВОПРОСЫ. <span>2/3</span></h1>
          <h3 class="center">Как бы Вы оценили дизайн Kent Explore?</h3>
          <form method="POST" action="/">
            <div class="row md-center">
              <div class="col-xs-12 col-sm-4">
                <input id="r-1" type="radio" name="design" value="Неудовлетворительно" class="radio"/><label for="r-1"><span>Неудовлетворительно</span></label>
              </div>
              <div class="col-xs-12 col-sm-4">
                <input id="r-2" type="radio" name="design" value="Хорошо" class="radio"/><label for="r-2"><span>Хорошо</span></label>
              </div>
              <div class="col-xs-12 col-sm-4">
                <input id="r-3" type="radio" name="design" value="Превосходно" checked="checked" class="radio"/><label for="r-3"><span>Превосходно</span></label>
              </div>
            </div>
            <div class="center"><br/>
              <button type="submit" class="button">ответить</button>
            </div>
          </form>
        </div>
        <div class="contest__question contest__step contest__step--4">
          <h1 class="center">ВОПРОСЫ. <span>3/3</span></h1>
          <h3 class="center">Успели ли Вы оценить вкус Kent Explore?</h3>
          <form method="POST" action="/">
            <div class="row center">
              <div class="col-xs-6">
                <button type="submit" name="check" value="Да" class="button button--small">Да</button>
              </div>
              <div class="col-xs-6">
                <button type="submit" name="check" value="Нет" class="button button--small">Нет</button>
              </div>
            </div>
          </form>
        </div>
        <div class="contest__question contest__step contest__step--5">
          <!--.contest__step--active-->
          <div class="center">
            <h1>Выбор свитшота</h1>
            <div class="row">
              <div class="col-xs-6">
                <div class="wear wear--male"><img src="/group/u_contest/images/man.png" alt="" class="wear__image"/><img src="/group/u_contest/images/fade.png" alt="" class="wear__hover"/><img src="/group/u_contest/images/man-shadow.png" alt="" class="wear__down"/><img src="/group/u_contest/images/men-shadow-normal.png" alt="" class="wear__shadow"/><img src="/group/u_contest/images/shadow.png" alt="" class="wear__fade"/>
                  <div class="wear__sizes"><span>Выберите размер:</span>
                    <input id="c-48" type="radio" name="size" value="48" checked="checked"/>
                    <label for="c-48">48</label>
                    <input id="c-50" type="radio" name="size" value="50"/>
                    <label for="c-50">50</label>
                  </div>
                  <div class="wear__checkbox">
                    <input id="man" type="radio" name="type" value="male" class="radio"/>
                    <label for="man">Мужской</label>
                  </div>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="wear wear--female"><img src="/group/u_contest/images/woman.png" alt="" class="wear__image"/><img src="/group/u_contest/images/fade.png" alt="" class="wear__hover"/><img src="/group/u_contest/images/man-shadow.png" alt="" class="wear__down"/><img src="/group/u_contest/images/women-shadow-normal.png" alt="" class="wear__shadow"/><img src="/group/u_contest/images/shadow.png" alt="" class="wear__fade"/>
                  <div class="wear__sizes"><span>Выберите размер:</span>
                    <input id="c-44" type="radio" name="size" value="44" checked="checked"/>
                    <label for="c-44">44</label>
                    <input id="c-46" type="radio" name="size" value="46"/>
                    <label for="c-46">46</label>
                  </div>
                  <div class="wear__checkbox">
                    <input id="female" type="radio" name="type" value="female" class="radio"/>
                    <label for="female">Женский</label>
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="button">Следующий шаг</button><br/>
            <div class="error">Пожалуйста, выберите свитшот,<br/>чтобы перейти к его оформлению</div>
          </div>
        </div>
        <div class="contest__question contest__step contest__step--6">
          <div class="center">
            <h1>Дизайн</h1>
            <div class="message visible-xs visible-sm">Выберите по одному элементу из каждой колонки<br/>для создания собственного дизайна.</div>
            <div class="row">
              <div class="col-sm-3 col-xs-6"><img src="/group/u_contest/images/svg/horizont.svg" alt="" class="icon"/><br/>
                <div class="pattern">
                  <input id="h-1" type="radio" name="horizont" value="1"/>
                  <label style="background-image: url(/group/u_contest/images/p-4.jpg)" for="h-1"></label>
                </div>
                <div class="pattern">
                  <input id="h-2" type="radio" name="horizont" value="2"/>
                  <label style="background-image: url(/group/u_contest/images/p-6.jpg)" for="h-2"></label>
                </div>
                <div class="pattern">
                  <input id="h-3" type="radio" name="horizont" value="3"/>
                  <label style="background-image: url(/group/u_contest/images/p-5.jpg)" for="h-3"></label>
                </div>
              </div>
              <div class="col-sm-3 col-sm-push-6 col-xs-6"><img src="/group/u_contest/images/svg/vertical.svg" alt="" class="icon"/><br/>
                <div class="pattern">
                  <input id="v-1" type="radio" name="vertical" value="1"/>
                  <label style="background-image: url(/group/u_contest/images/p-3.jpg)" for="v-1"></label>
                </div>
                <div class="pattern">
                  <input id="v-2" type="radio" name="vertical" value="2"/>
                  <label style="background-image: url(/group/u_contest/images/p-2.jpg)" for="v-2"></label>
                </div>
                <div class="pattern">
                  <input id="v-3" type="radio" name="vertical" value="3"/>
                  <label style="background-image: url(/group/u_contest/images/p-1.jpg)" for="v-3"></label>
                </div>
              </div>
              <div class="col-sm-6 col-sm-pull-3 col-xs-12">
                <div class="wear wear--male wear--disabled hidden"><img src="/group/u_contest/images/man.png" alt="" class="wear__image"/><img src="/group/u_contest/images/fade.png" alt="" class="wear__hover"/><img src="/group/u_contest/images/man-shadow.png" alt="" class="wear__down"/><img src="/group/u_contest/images/men-shadow-normal.png" alt="" class="wear__shadow"/><img src="/group/u_contest/images/shadow.png" alt="" class="wear__fade"/>
                  <div class="wear__text"><img src="/group/u_contest/images/design_lines.png" alt=""/></div>
                  <div class="wear__placeholder"><img src="/group/u_contest/images/design_1_1.png" alt=""/><img src="/group/u_contest/images/design_1_2.png" alt=""/><img src="/group/u_contest/images/design_1_3.png" alt=""/><img src="/group/u_contest/images/design_2_1.png" alt=""/><img src="/group/u_contest/images/design_2_2.png" alt=""/><img src="/group/u_contest/images/design_2_3.png" alt=""/></div>
                </div>
                <div class="wear wear--female wear--disabled hidden"><img src="/group/u_contest/images/woman.png" alt="" class="wear__image"/><img src="/group/u_contest/images/fade.png" alt="" class="wear__hover"/><img src="/group/u_contest/images/man-shadow.png" alt="" class="wear__down"/><img src="/group/u_contest/images/women-shadow-normal.png" alt="" class="wear__shadow"/><img src="/group/u_contest/images/shadow.png" alt="" class="wear__fade"/>
                  <div class="wear__text"><img src="/group/u_contest/images/design_lines.png" alt=""/></div>
                  <div class="wear__placeholder"><img src="/group/u_contest/images/design_1_1.png" alt=""/><img src="/group/u_contest/images/design_1_2.png" alt=""/><img src="/group/u_contest/images/design_1_3.png" alt=""/><img src="/group/u_contest/images/design_2_1.png" alt=""/><img src="/group/u_contest/images/design_2_2.png" alt=""/><img src="/group/u_contest/images/design_2_3.png" alt=""/></div>
                </div>
                <div class="message visible-md visible-lg">Выберите по одному элементу из каждой колонки<br/>для создания собственного дизайна.</div>
              </div>
            </div>
            <button type="submit" class="button">Подтвердить</button>
          </div>
        </div>
        <div class="contest__question contest__step contest__step--7">
          <h1 class="center">Подтверждение</h1>
          <div class="row">
            <div class="col-sm-5 col-sm-pull-1 col-xs-12">
              <div class="wear wear--male wear--disabled hidden"><img src="/group/u_contest/images/man.png" alt="" class="wear__image"/><img src="/group/u_contest/images/fade.png" alt="" class="wear__hover"/><img src="/group/u_contest/images/man-shadow.png" alt="" class="wear__down"/><img src="/group/u_contest/images/men-shadow-normal.png" alt="" class="wear__shadow"/><img src="/group/u_contest/images/shadow.png" alt="" class="wear__fade"/>
                <div class="wear__text"><img src="/group/u_contest/images/design_lines.png" alt=""/></div>
                <div class="wear__placeholder"><img src="/group/u_contest/images/design_1_1.png" alt=""/><img src="/group/u_contest/images/design_1_2.png" alt=""/><img src="/group/u_contest/images/design_1_3.png" alt=""/><img src="/group/u_contest/images/design_2_1.png" alt=""/><img src="/group/u_contest/images/design_2_2.png" alt=""/><img src="/group/u_contest/images/design_2_3.png" alt=""/></div>
              </div>
              <div class="wear wear--female wear--disabled hidden"><img src="/group/u_contest/images/woman.png" alt="" class="wear__image"/><img src="/group/u_contest/images/fade.png" alt="" class="wear__hover"/><img src="/group/u_contest/images/man-shadow.png" alt="" class="wear__down"/><img src="/group/u_contest/images/women-shadow-normal.png" alt="" class="wear__shadow"/><img src="/group/u_contest/images/shadow.png" alt="" class="wear__fade"/>
                <div class="wear__text"><img src="/group/u_contest/images/design_lines.png" alt=""/></div>
                <div class="wear__placeholder"><img src="/group/u_contest/images/design_1_1.png" alt=""/><img src="/group/u_contest/images/design_1_2.png" alt=""/><img src="/group/u_contest/images/design_1_3.png" alt=""/><img src="/group/u_contest/images/design_2_1.png" alt=""/><img src="/group/u_contest/images/design_2_2.png" alt=""/><img src="/group/u_contest/images/design_2_3.png" alt=""/></div>
              </div>
              <div class="shares"><a href="#" target='_blank' class="share share--vk"><svg xmlns="http://www.w3.org/2000/svg" width="1173.404" height="681.417" viewBox="0 0 1173.404 681.417"><path fill-rule="evenodd" clip-rule="evenodd" d="M.96 48.1c.562-.5 1.457-.903 1.63-1.514 1.21-4.23 4.308-6.58 7.977-8.455 6.89-3.52 14.18-5.846 21.766-7.243 6.774-1.247 13.61-2.004 20.506-2.02 12.797-.034 25.596 0 38.394-.017 27.836-.04 55.672-.072 83.508-.16 5.758-.018 11.518-.193 17.272-.414 8.538-.327 16.928.823 25.235 2.56 11.968 2.504 21.028 9.1 26.71 19.998 7.168 13.753 14.34 27.506 20.496 41.76 27.995 64.826 62.507 126.015 102.838 183.943 6.305 9.056 12.775 18 19.283 26.912 2.45 3.353 5.15 6.53 7.857 9.688 6.037 7.042 13.484 12.218 21.86 16.083 3.07 1.418 6.304 2.23 9.736 2.285 5.656.09 10.345-1.987 13.936-6.268 1.625-1.938 3.04-4.145 4.12-6.432 4.865-10.303 8.754-20.96 10.48-32.275.99-6.477 1.686-13 2.417-19.515 1.696-15.106 2.797-30.262 3.415-45.447.768-18.87.85-37.745-.11-56.612-.382-7.507-.792-15.017-1.407-22.507-.888-10.836-1.666-21.694-3.795-32.38-.936-4.702-1.957-9.398-3.22-14.02-4.69-17.13-15.25-29.242-31.497-36.41-10.093-4.453-20.18-8.92-30.264-13.39-1.155-.513-2.28-1.094-3.684-1.772.373-1 .584-1.9 1.017-2.677 6.31-11.354 15.274-20.017 26.688-26.177 8.367-4.516 17.315-7.448 26.517-9.654C455.312 2.45 470.222.567 485.28.124 521.745-.948 558.22-.95 594.69 0c5.912.154 11.83.37 17.728.793 10.402.746 20.544 3.052 30.642 5.536 3.104.762 6.214 1.54 9.246 2.537 13.947 4.587 24.103 13.508 30.405 26.803 3.39 7.15 5.294 14.72 6.525 22.488 1.43 9.024 2.01 18.106 2.11 27.24.158 14.573-.81 29.1-1.548 43.637-.414 8.147-.97 16.287-1.41 24.432-.788 14.535-1.565 29.07-2.295 43.608-.97 19.33-1.946 38.66-2.8 57.997-.418 9.453.06 18.864 2.086 28.157 2.244 10.29 6.156 19.844 12.515 28.29 2.883 3.83 6.07 7.433 9 11.23 2.383 3.088 5.57 4.198 9.265 4.058 1.736-.066 3.493-.407 5.178-.858 6.59-1.762 12.414-5.04 17.752-9.233 5.827-4.58 10.836-9.978 15.292-15.85 9.572-12.61 19.282-25.135 28.423-38.057 36.833-52.066 66.72-107.927 90.708-166.992 5.113-12.587 10.653-25.002 16.064-37.467 1.016-2.338 2.234-4.61 3.558-6.79 8.157-13.448 20.27-21.022 35.627-23.493 4.4-.708 8.91-1.032 13.368-1.017 11.196.037 22.39.416 33.587.57 14.716.2 29.434.394 44.15.45 27.837.104 55.675.02 83.51.198 11.194.072 22.403.414 33.533 1.743 5.385.645 10.817 1.38 16.04 2.78 13.035 3.493 20.27 12.112 19.943 27.255-.103 4.81-1.048 9.53-2.225 14.19-4.21 16.667-10.56 32.52-18.278 47.844-9.586 19.033-20.827 37.08-32.762 54.707-14.988 22.137-31.293 43.297-47.847 64.27-23.39 29.633-46.59 59.414-69.172 89.672-6.543 8.767-11.8 18.253-16.103 28.28-2.213 5.157-3.753 10.513-4.688 16.07-1.91 11.36.232 21.938 5.747 31.93 3.664 6.64 8.376 12.493 13.787 17.755 11.47 11.15 22.956 22.288 34.582 33.276 18.954 17.917 37.737 35.998 55.53 55.086 23.384 25.088 45.024 51.556 63.946 80.207 6.65 10.068 12.09 20.69 15.95 32.126 1.188 3.516 1.902 7.087 2.025 10.796.265 8.018-2.2 15.104-7.173 21.354-2.718 3.414-5.995 6.2-9.634 8.58-9.964 6.524-20.976 10.185-32.72 11.564-5.704.67-11.482 1.012-17.225.992-19.036-.064-38.07-.386-57.107-.562-15.677-.145-31.356-.395-47.03-.255-7.665.066-15.325.86-22.98 1.424-8.453.62-16.892 1.467-25.35 2-5.633.353-11.142-.813-16.598-2.12-28.954-6.94-54.222-20.825-76.027-40.946-7.63-7.04-14.884-14.54-21.838-22.255-14.353-15.92-28.33-32.18-42.58-48.193-6.91-7.766-13.96-15.42-21.2-22.875-3.887-4.004-8.172-7.66-12.53-11.16-7.647-6.14-16.436-9.796-26.187-11.045-12.062-1.545-26.887 3.004-33.57 19.21-2.756 6.68-4.372 13.71-5.67 20.788-2.914 15.896-5.057 31.89-6.02 48.043-.6 10.054-1.427 20.11-3.683 29.968-.712 3.108-1.607 6.19-2.643 9.207-3.287 9.587-9.678 16.395-18.818 20.703-6.27 2.954-12.89 4.78-19.646 6.105-17.36 3.404-34.894 4.394-52.534 3.366-11.495-.67-22.99-1.415-34.462-2.38-38.056-3.197-75.458-9.755-111.643-22.312-42.154-14.63-80.24-36.49-114.7-64.766-16.602-13.625-32.082-28.43-46.535-44.31-32.244-35.423-61.824-72.976-89.43-112.1-31.66-44.867-60.49-91.516-87.57-139.266-33.864-59.72-64.49-121.078-92.71-183.646C10.692 96.117 6.246 80.14 3.784 63.602c-.4-2.688-.73-5.386-1.1-8.078C2.53 54.38 2.243 53.31.96 52.9v-4.8z" fill="#FFF"/></svg></a><a href="#" target='_blank' class="share share--fb"><svg width="13" height="27" viewBox="0 0 13 27" xmlns="http://www.w3.org/2000/svg"><path d="M2.672 13.155c.067.084.03.67.03.78l.003 12.343h5.352c.03-3.25 0-6.584 0-9.848 0-.047-.01-3.163.004-3.228l.024-.055c.007 0 3.405.028 3.523 0l.06-.018.47-4.507H8.075c-.016-.665.003-1.35.004-2.017 0-.61-.016-1.36.347-1.696l3.69-.37L12.11.02c-.698-.043-1.526-.004-2.238-.004C9.13.016 8.38 0 7.652.05 6.26.14 5.14.554 4.328 1.245c-1.177 1.885-1.632.266-1.64 7.38H0l.005 4.526 2.667.003" fill="#fff"/></svg></a>

              </div>
            </div>
            <div class="col-sm-7 col-xs-12">
              <h3>Пожалуйста, укажите свои контактные<br/>данные, чтобы продолжить.</h3>
              <form data-parsley-validate="data-parsley-validate">
                <label for="address">Адрес доставки в г. Екатеринбург</label>
                <input id="address" type="text" name="address" required="required"/>
                <div class="row">
                  <div class="col-xs-12 col-sm-5">
                    <label for="phone">Телефон</label><br/><span class="number">+7</span>
                    <input id="phone" type="text" name="phone" placeholder="(    )     -   -" data-parsley-minlength="15" data-parsley-trigger="change" required="required"/>
                  </div>
                  <div class="col-xs-12 col-sm-7">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" name="email" data-parsley-trigger="change" required="required"/>
                  </div>
                </div>
                <button type="submit" class="button">Подтвердить</button>
              </form>
              <div class="error">Пожалуйста, укажите свои контактные данные</div>
            </div>
          </div>
        </div>
      </div>
